<?php

namespace App\Http\Controllers\User\TTS;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MergeService;
use App\Services\AWSTTSService;
use App\Services\AzureTTSService;
use App\Services\GCPTTSService;
use App\Services\IBMTTSService;
use App\Models\VoiceoverResult;
use App\Models\User;
use App\Models\VoiceoverLanguage;
use App\Models\Voice;
use App\Models\Project;
use Carbon\Carbon;
use DataTables;
use DB;

use GuzzleHttp\Client;


class VoiceoverStudioController extends Controller
{
    private $api;
    private $merge_files;

    public function __construct()
    {
        $this->api = new LicenseController();
        $this->merge_files = new MergeService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # Today's TTS Results for Datatable
        if ($request->ajax()) {
            $data = VoiceoverResult::where('user_id', Auth::user()->id)->where('mode', 'file')->whereDate('created_at', Carbon::today())->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                        <a href="' . route("user.voiceover.show", $row["id"]) . '"><i class="fa-solid fa-list-music table-action-buttons view-action-button" title="View Result"></i></a>
                                        <a class="deleteResultButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Result"></i></a>
                                    </div>';
                    return $actionBtn;
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span>' . date_format($row["created_at"], 'd M Y') . '</span>';
                    return $created_on;
                })
                ->addColumn('custom-voice-type', function ($row) {
                    $custom_voice = '<span class="cell-box voice-' . strtolower($row["voice_type"]) . '">' . ucfirst($row["voice_type"]) . '</span>';
                    return $custom_voice;
                })
                ->addColumn('vendor', function ($row) {
                    $path = URL::asset($row['vendor_img']);
                    $vendor = '<div class="vendor-image-sm overflow-hidden"><img alt="vendor" src="' . $path . '"></div>';
                    return $vendor;
                })
                ->addColumn('download', function ($row) {
                    $url = ($row['storage'] == 'local') ? URL::asset($row['result_url']) : $row['result_url'];
                    $result = '<a class="" href="' . $url . '" download><i class="fa fa-cloud-download table-action-buttons download-action-button" title="Download Result"></i></a>';
                    return $result;
                })
                ->addColumn('single', function ($row) {
                    $url = ($row['storage'] == 'local') ? URL::asset($row['result_url']) : $row['result_url'];
                    $result = '<button type="button" class="result-play p-0" onclick="resultPlay(this)" src="' . $url . '" type="' . $row['audio_type'] . '" id="' . $row['id'] . '"><i class="fa fa-play table-action-buttons view-action-button" title="Play Result"></i></button>';
                    return $result;
                })
                ->addColumn('result', function ($row) {
                    $result = ($row['storage'] == 'local') ? URL::asset($row['result_url']) : $row['result_url'];
                    return $result;
                })
                ->addColumn('custom-language', function ($row) {
                    $language = '<span class="vendor-image-sm overflow-hidden"><img class="mr-2" src="' . URL::asset($row['language_flag']) . '">' . $row['language'] . '</span> ';
                    return $language;
                })
                ->rawColumns(['actions', 'created-on', 'custom-voice-type', 'result', 'vendor', 'download', 'single', 'custom-language'])
                ->make(true);
        }

        # Set Voice Types as Listed in TTS Config
        if (config('tts.voice_type') == 'standard') {
            $languages = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
                ->where('vendors.enabled', '1')
                ->where('voices.status', 'active')
                ->where('voices.voice_type', 'standard')
                ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
                ->distinct()
                ->orderBy('voiceover_languages.language', 'asc')
                ->get();

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'standard')
                ->where('voices.status', 'active')
                ->orderBy('voices.voice_type', 'desc')
                ->orderBy('voices.voice', 'asc')
                ->get();
        } elseif (config('tts.voice_type') == 'neural') {
            $languages = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
                ->where('vendors.enabled', '1')
                ->where('voices.status', 'active')
                ->where('voices.voice_type', 'neural')
                ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
                ->distinct()
                ->orderBy('voiceover_languages.language', 'asc')
                ->get();

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'neural')
                ->where('voices.status', 'active')
                ->orderBy('voices.voice_type', 'desc')
                ->orderBy('voices.voice', 'asc')
                ->get();
        } else {
            if ((is_null(auth()->user()->voice_type) && (config('tts.voice_type') == 'both')) || (auth()->user()->voice_type == 'both')) {
                $languages = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
                    ->where('vendors.enabled', '1')
                    ->where('voices.status', 'active')
                    ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
                    ->distinct()
                    ->orderBy('voiceover_languages.language', 'asc')
                    ->get();

                $voices = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->where('vendors.enabled', '1')
                    ->where('voices.status', 'active')
                    ->orderBy('voices.voice_type', 'desc')
                    ->orderBy('voices.voice', 'asc')
                    ->get();
            } elseif (auth()->user()->voice_type == 'standard') {
                $languages = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
                    ->where('vendors.enabled', '1')
                    ->where('voices.status', 'active')
                    ->where('voices.voice_type', 'standard')
                    ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
                    ->distinct()
                    ->orderBy('voiceover_languages.language', 'asc')
                    ->get();

                $voices = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->where('vendors.enabled', '1')
                    ->where('voices.voice_type', 'standard')
                    ->where('voices.status', 'active')
                    ->orderBy('voices.voice_type', 'desc')
                    ->orderBy('voices.voice', 'asc')
                    ->get();
            } elseif (auth()->user()->voice_type == 'neural') {
                $languages = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
                    ->where('vendors.enabled', '1')
                    ->where('voices.status', 'active')
                    ->where('voices.voice_type', 'neural')
                    ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
                    ->distinct()
                    ->orderBy('voiceover_languages.language', 'asc')
                    ->get();

                $voices = DB::table('voices')
                    ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                    ->where('vendors.enabled', '1')
                    ->where('voices.voice_type', 'neural')
                    ->where('voices.status', 'active')
                    ->orderBy('voices.voice_type', 'desc')
                    ->orderBy('voices.voice', 'asc')
                    ->get();
            }
        }
        # Max Chars for Textarea and Textarea Counter
        $vendor_logo['status'] = json_encode((config('tts.vendor_logos') == 'show') ? 'show' : 'none');

        $projects = Project::where('user_id', auth()->user()->id)->get();

        return view('user.voiceover.index', compact('languages', 'voices', 'vendor_logo', 'projects'));
    }

    /**
     * Process text synthesize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function videoDubStudio()
    {

        // http://um-wm-dev.ap-south-1.elasticbeanstalk.com/vaanee/supported-languages
        $client = new Client();
        $yourAccessToken = getAccessToken();
        $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/supported-languages', [
            // You can customize the request further, such as adding headers
            'headers' => [
                'Authorization' => 'Bearer ' . $yourAccessToken,
            ],
        ]);

        $langs = json_decode($response->getBody()->getContents());
        $languages = $langs->result;
        $model_names = [];
        foreach ($languages as $value) {
            cache([$value->model_name => $value->supported_languages]);
            $model_names[] = $value->model_name;
        }
        cache(['model_name' => $model_names]);

        $models = cache('model_name');

        // $voices = DB::table('voices')
        //     ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
        //     ->where('vendors.enabled', '1')
        //     ->where('voices.voice_type', 'neural')
        //     ->where('voices.status', 'active')
        //     ->orderBy('voices.voice_type', 'desc')
        //     ->orderBy('voices.voice', 'asc')
        //     ->get();
        return view('user.voiceover.video-dub-studio', compact(
            'models', 
            // 'voices', 
            'languages'
        ));
    }

    /**
     * Process text synthesize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createProject(Request $request)
    {
        // Validation
        // Create a new Guzzle client instance
        if ($request->format === 'vlippr') {
            $videoFormat = 'm3u8';
        } else {
            $videoFormat = 'mp4';
        }

        if ($request->project_type === 'audio') {
            $videoFormat = 'a';
        }
        if ($request->project_type === 'text') {
            $videoFormat = 't';
        }

        $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/project/';
        $client = new Client();
        $postData = [
            'project_name' => $request->project_title ?? '',
            'project_type' => $request->project_type ?? '',
            'modal' => $request->model ?? '',
            'video_format' => $videoFormat,
            'downloadable' => $request->downloadable ?? 'yes',
            // Add more key-value pairs as needed
        ];

        $yourAccessToken = getAccessToken();

        try {
            // Make a POST request to the API
            $response = $client->post($apiUrl, [
                'json' => $postData,
                // You can customize the request further, such as adding headers
                'headers' => [
                    'Authorization' => 'Bearer ' . $yourAccessToken,
                ],
            ]);

            // Get the response body as a string
            $responseBody = $response->getBody()->getContents();
            return response()->json(['message' => 'Data sent successfully', 'response' => json_decode($responseBody)], 200);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Process text synthesize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadVideo(Request $request)
    {
        if ($request->hasFile('video')) {
            // Create a new Guzzle client instance
            $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/upload_video/';
            $client = new Client();

            $yourAccessToken = getAccessToken();
            
            try {
                if ($request->project_id) {
                    if($request->project_type == 'audio'){
                        $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/upload_audio/';
                    }
                    if($request->project_type == 'text'){
                        $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/upload_transcript/';
                    }

                    // Make a POST request to the API
                    $response = $client->post($apiUrl, [
                        'multipart' => [
                            [
                                'name'     => 'file',    // Field name for the file
                                'contents' => fopen($request->file('video')->getPathname(), 'r'),  // Open the file for reading
                                'filename' => Time().rand(1,1000000000).".".$request->file('video')->getClientOriginalExtension(),
                            ],
                            // Add other form fields as needed
                            [
                                'name'     => 'project_id',
                                'contents' => $request->project_id,
                            ],
                            // Add more fields if necessary
                        ],
                        // You can customize the request further, such as adding headers
                        'headers' => [
                            'Authorization' => 'Bearer ' . $yourAccessToken,
                        ],
                    ]);
                    User::where('id', auth()->id())->update([
                        'available_chars' => auth()->user()->available_chars - $request->characters_required_for_upload
                    ]);
                    // Get the response body as a string
                    $responseBody = $response->getBody()->getContents();
                    return response()->json(['message' => 'Data sent successfully', 'response' => json_decode($responseBody)], 200);
                } else {
                    return response()->json(['error' => 'Project not found! Please create project first.', 'response' => ''], 500);
                }
            } catch (\Exception $e) {
                // Handle any exceptions that may occur
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    /**
     * Upload video metadata.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadVideoMetaData(Request $request)
    {
        try {
            if ($request->id) {

                $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/video_metadata/' . $request->id . '/';
                if($request->project_type == 'audio'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/audio_metadata/' . $request->id . '/';
                }
                if($request->project_type == 'text'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/transcript_metadata/' . $request->id . '/';
                }
                $client = new Client();
                $yourAccessToken = getAccessToken();
                $status = [];
                if ($request->language === 'multiple-language') {
                    $required_lang = $request->multi_target_language;
                } else {
                    $required_lang = [$request->single_target_language];
                }
                foreach ($required_lang as $value) {
                    $status[$value] = 'pending';
                }
                // this code breaks if language === single-language
                // $status = [];
                // foreach ($required_lang as $value) {
                //     $status[$value] = 'pending';
                // }

                $data = [
                    'source_lang' => $request->source,
                    'required_languages' => $required_lang,
                    'status' => $status,
                    'single_speaker' => false,
                    'is_active' => false,
                    'title' => $request->title,
                    'description' => $request->description,
                    's3_path' => $request->s3_url,
                    'audio_path' => null,
                    'multi_audio' => false,
                    'save_action' => true,
                ];

                // Make a POST request to the API
                $response = $client->patch($apiUrl, [
                    'json' => $data,
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Transcription generated', 'response' => json_decode($responseBody)], 200);
            } else {
                return response()->json(['error' => 'Video not found! Please upload video first.', 'response' => ''], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateTranscript(Request $request)
    {
        try {
            if ($request->project_id) {
                $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-transcript/?project_id=' . $request->project_id;
                if($request->project_type == 'audio'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-audio-transcript/?project_id=' . $request->project_id;
                }
                $client = new Client();
                $yourAccessToken = getAccessToken();

                $data = [];

                // Make a POST request to the API
                $response = $client->get($apiUrl, [
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Data sent successfully', 'response' => json_decode($responseBody)], 200);
            } else {
                return response()->json(['error' => 'Project not found!', 'response' => ''], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function patchGenerateTranscript(Request $request)
    {
        try {
            if ($request->project_id) {
                $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-transcript/?action=' . $request->action;
                if($request->project_type == 'audio'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-audio-transcript/?action=' . $request->action;
                }
                $client = new Client();
                $yourAccessToken = getAccessToken();

                $data = [
                    "project_id" => $request->project_id,
                    "source_text" => $request->source_text,
                    "duration" => $request->duration,
                    "s3_path" => $request->s3_path,
                ];

                // Make a POST request to the API
                $response = $client->patch($apiUrl, [
                    'json' => $data,
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Patch transcription successfully', 'response' => json_decode($responseBody)], 200);
            } else {
                return response()->json(['error' => 'Project not found!', 'response' => ''], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateTargetTranscript(Request $request)
    {
        try {
            if ($request->project_id) {
                $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-target-transcription/?project_id=' . $request->project_id;
                if($request->project_type == 'audio'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-target-audio-transcription/?project_id=' . $request->project_id;
                }
                $client = new Client();
                $yourAccessToken = getAccessToken();

                $data = [];

                // Make a POST request to the API
                $response = $client->get($apiUrl, [
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Target transcription generated', 'response' => json_decode($responseBody)], 200);
            } else {
                return response()->json(['error' => 'Project not found!', 'response' => ''], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function patchGenerateTargetTranscript(Request $request)
    {
        try {
            // return $request->data[0]['source_text'];
            if ($request->project_id) {
                $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-target-transcription/?project_id='.$request->project_id.'&action=' . $request->action;
                if($request->project_type == 'audio'){
                    $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/generate-target-audio-transcription/?project_id='.$request->project_id.'&action=' . $request->action;
                }
                $client = new Client();
                $yourAccessToken = getAccessToken();

                $data = $request->data;

                // Make a POST request to the API
                $response = $client->patch($apiUrl, [
                    'json' => $data,
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Patch target transcription successfully', 'response' => json_decode($responseBody)], 200);
            } else {
                return response()->json(['error' => 'Project not found!', 'response' => ''], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function audioDubStudio()
    {
        $client = new Client();
        $yourAccessToken = getAccessToken();
        $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/supported-languages', [
            // You can customize the request further, such as adding headers
            'headers' => [
                'Authorization' => 'Bearer ' . $yourAccessToken,
            ],
        ]);

        $langs = json_decode($response->getBody()->getContents());
        $languages = $langs->result;
        $model_names = [];
        foreach ($languages as $value) {
            cache([$value->model_name => $value->supported_languages]);
            $model_names[] = $value->model_name;
        }
        cache(['model_name' => $model_names]);

        $voices = DB::table('voices')
            ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
            ->where('vendors.enabled', '1')
            ->where('voices.voice_type', 'neural')
            ->where('voices.status', 'active')
            ->orderBy('voices.voice_type', 'desc')
            ->orderBy('voices.voice', 'asc')
            ->get();

        $models = cache('model_name');
        return view('user.voiceover.audio-dub-studio', compact('models', 'voices', 'languages'));
    }

    public function textDubStudio()
    {
        $client = new Client();
        $yourAccessToken = getAccessToken();
        $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/supported-languages', [
            // You can customize the request further, such as adding headers
            'headers' => [
                'Authorization' => 'Bearer ' . $yourAccessToken,
            ],
        ]);

        $langs = json_decode($response->getBody()->getContents());
        $languages = $langs->result;
        $model_names = [];
        foreach ($languages as $value) {
            cache([$value->model_name => $value->supported_languages]);
            $model_names[] = $value->model_name;
        }
        cache(['model_name' => $model_names]);

        // $voices = DB::table('voices')
        //     ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
        //     ->where('vendors.enabled', '1')
        //     ->where('voices.voice_type', 'neural')
        //     ->where('voices.status', 'active')
        //     ->orderBy('voices.voice_type', 'desc')
        //     ->orderBy('voices.voice', 'asc')
        //     ->get();

        $models = cache('model_name');
        return view('user.voiceover.text-dub-studio', compact(
            'models', 
            // 'voices', 
            'languages'
        ));
    }

    /**
     * Process text synthesize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function synthesize(Request $request)
    {
        if ($this->api->api_url != 'https://license.berkine.space/') {
            return redirect()->back();
        }

        $input = json_decode(request('input_text'), true);
        $length = count($input);

        if ($request->ajax()) {

            request()->validate([
                'title' => 'nullable|string|max:255',
            ]);

            # Count characters based on vendor requirements
            $total_characters = mb_strlen(request('input_text_total'), 'UTF-8');

            # Protection from overusage of credits
            if (Auth::user()->group == 'user') {
                if ($total_characters > config('tts.free_chars_limit')) {
                    return response()->json(["error" => __("Total characters of your text is more than allowed, maximum ") . config('tts.free_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            } else {
                if ($total_characters > config('tts.max_chars_limit')) {
                    return response()->json(["error" => __("Total characters of your text is more than allowed, maximum ") . config('tts.max_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            }

            # Check if user has enough characters to proceed
            if ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) < $total_characters) {
                return response()->json(["error" => __("Not enough available characters to process")], 422);
            }

            # Check if user has enough synthesize tasks left to proceed
            if ((Auth::user()->synthesize_tasks != -1) && (Auth::user()->synthesize_tasks == 0)) {
                return response()->json(["error" => __("You have depleted synthesize tasks for current month")], 422);
            }


            # Variables for recording
            $total_text = '';
            $total_text_raw = '';
            $total_text_characters = 0;
            $inputAudioFiles = [];
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';

            # Audio Format
            if (request('format') == 'mp3') {
                $audio_type = 'audio/mpeg';
            } elseif (request('format') == 'wav') {
                $audio_type = 'audio/wav';
            } elseif (request('format') == 'ogg') {
                $audio_type = 'audio/ogg';
            } elseif (request('format') == 'webm') {
                $audio_type = 'audio/webm';
            }

            # Process each textarea row
            foreach ($input as $key => $value) {
                $voice_id = explode('___', $key);
                $voice = Voice::where('voice_id', $voice_id[0])->first();
                $language = VoiceoverLanguage::where('language_code', $voice->language_code)->first();
                $no_ssml_tags = preg_replace('/<[\s\S]+?>/', '', $value);

                if ($length > 1) {
                    $total_text .= $voice->voice . ': ' . preg_replace('/<[\s\S]+?>/', '', $value) . '. ';
                    $total_text_raw .= $voice->voice . ': ' . $value . '. ';
                } else {
                    $total_text = preg_replace('/<[\s\S]+?>/', '', $value) . '. ';
                    $total_text_raw = $value . '. ';
                }


                # Count characters based on vendor requirements
                switch ($voice->vendor) {
                    case 'aws':
                        $text_characters = mb_strlen($no_ssml_tags, 'UTF-8');
                        $total_text_characters += $text_characters;
                        break;
                    case 'gcp':
                    case 'ibm':
                        $text_characters = mb_strlen($value, 'UTF-8');
                        $total_text_characters += $text_characters;
                        break;
                    case 'azure':
                        $text_characters = $this->countAzureCharacters($voice, $value);
                        $total_text_characters += $text_characters;
                        break;
                }


                # Check if user has characters available to proceed
                if ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) < $text_characters) {
                    return response()->json(["error" => __("Not enough available characters to process")], 422);
                } else {
                    $this->updateAvailableCharacters($text_characters);
                }


                # Name and extention of the result audio file
                if (request('format') === 'mp3') {
                    $temp_file_name = Str::random(10) . '.mp3';
                } elseif (request('format') === 'ogg') {
                    $temp_file_name = Str::random(10) . '.ogg';
                } elseif (request('format') === 'webm') {
                    $temp_file_name = Str::random(10) . '.webm';
                } elseif (request('format') === 'wav') {
                    $temp_file_name = Str::random(10) . '.wav';
                } else {
                    return response()->json(["error" => __("Unsupported audio file extension was selected")], 422);
                }


                switch ($voice->vendor) {
                    case 'aws':
                        if (request('format') != 'wav' && request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $temp_file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'azure':
                        if (request('format') != 'wav') {
                            $response = $this->processText($voice, $value, request('format'), $temp_file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'gcp':
                        if (request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $temp_file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'ibm':
                        if (request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $temp_file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    default:
                        # code...
                        break;
                }


                if ($length == 1) {

                    if (config('tts.default_storage') === 's3') {
                        Storage::disk('s3')->writeStream($temp_file_name, Storage::disk('audio')->readStream($temp_file_name));
                        $result_url = Storage::disk('s3')->url($temp_file_name);
                        Storage::disk('audio')->delete($temp_file_name);
                    } elseif (config('tts.default_storage') == 'wasabi') {
                        Storage::disk('wasabi')->writeStream($temp_file_name, Storage::disk('audio')->readStream($temp_file_name));
                        $result_url = Storage::disk('wasabi')->url($temp_file_name);
                        Storage::disk('audio')->delete($temp_file_name);
                    } else {
                        $result_url = Storage::url($temp_file_name);
                    }

                    # Update user synthesize task number
                    $this->updateSynthesizeTasks();

                    $result = new VoiceoverResult([
                        'user_id' => Auth::user()->id,
                        'language' => $language->language,
                        'language_flag' => $language->language_flag,
                        'voice' => $voice->voice,
                        'voice_id' => $voice_id[0],
                        'gender' => $voice->gender,
                        'text' => $total_text,
                        'text_raw' => $total_text_raw,
                        'characters' => $text_characters,
                        'file_name' => $temp_file_name,
                        'result_ext' => request('format'),
                        'result_url' => $result_url,
                        'title' =>  htmlspecialchars(request('title')),
                        'project' => request('project'),
                        'vendor_img' => $voice->vendor_img,
                        'voice_type' => $voice->voice_type,
                        'vendor' => $voice->vendor,
                        'vendor_id' => $voice->vendor_id,
                        'audio_type' => $audio_type,
                        'storage' => config('tts.default_storage'),
                        'plan_type' => $plan_type,
                        'mode' => 'file',
                    ]);

                    $result->save();

                    return response()->json(["success" => __("Success! Text was synthesized successfully")], 200);
                } else {

                    array_push($inputAudioFiles, 'storage/' . $response['name']);

                    $result = new VoiceoverResult([
                        'user_id' => Auth::user()->id,
                        'language' => $language->language,
                        'voice' => $voice->voice,
                        'voice_id' => $voice_id[0],
                        'text_raw' => $value,
                        'vendor' => $voice->vendor,
                        'vendor_id' => $voice->vendor_id,
                        'characters' => $text_characters,
                        'voice_type' => $voice->voice_type,
                        'plan_type' => $plan_type,
                        'storage' => config('tts.default_storage'),
                        'mode' => 'hidden',
                    ]);

                    $result->save();
                }
            }

            # Process multi voice merge process
            if ($length > 1) {

                # Name and extention of the main audio file
                if (request('format') == 'mp3') {
                    $file_name = Str::random(10) . '.mp3';
                } elseif (request('format') == 'ogg') {
                    $file_name = Str::random(10) . '.ogg';
                } elseif (request('format') == 'wav') {
                    $file_name = Str::random(10) . '.wav';
                } elseif (request('format') == 'webm') {
                    $file_name = Str::random(10) . '.webm';
                } else {
                    return response()->json(["error" => __("Unsupported audio file extension was selected")], 422);
                }

                # Update user synthesize task number
                $this->updateSynthesizeTasks();

                $this->merge_files->merge(request('format'), $inputAudioFiles, 'storage/' . $file_name);

                if (config('tts.default_storage') === 's3') {
                    Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                    $result_url = Storage::disk('s3')->url($file_name);
                    Storage::disk('audio')->delete($file_name);
                } elseif (config('tts.default_storage') == 'wasabi') {
                    Storage::disk('wasabi')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                    $result_url = Storage::disk('wasabi')->url($file_name);
                    Storage::disk('audio')->delete($file_name);
                } else {
                    $result_url = Storage::url($file_name);
                }

                $result = new VoiceoverResult([
                    'user_id' => Auth::user()->id,
                    'language' => $language->language,
                    'language_flag' => $language->language_flag,
                    'voice' => $voice->voice,
                    'voice_id' => $voice_id[0],
                    'gender' => $voice->gender,
                    'text' => $total_text,
                    'text_raw' => $total_text_raw,
                    'characters' => $total_text_characters,
                    'file_name' => $file_name,
                    'result_url' => $result_url,
                    'result_ext' => request('format'),
                    'title' => htmlspecialchars(request('title')),
                    'project' => request('project'),
                    'vendor_img' => $voice->vendor_img,
                    'voice_type' => 'mixed',
                    'vendor' => $voice->vendor,
                    'vendor_id' => $voice->vendor_id,
                    'storage' => config('tts.default_storage'),
                    'plan_type' => $plan_type,
                    'audio_type' => $audio_type,
                    'mode' => 'file',
                ]);

                $result->save();

                # Clean all temp audio files
                foreach ($inputAudioFiles as $value) {
                    $name_array = explode('/', $value);
                    $name = end($name_array);
                    if (Storage::disk('audio')->exists($name)) {
                        Storage::disk('audio')->delete($name);
                    }
                }

                return response()->json(["success" => __("Success! Text was synthesized successfully")], 200);
            }
        }
    }


    /**
     * Process listen synthesize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listen(Request $request)
    {
        if ($this->api->api_url != 'https://license.berkine.space/') {
            return redirect()->back();
        }

        $input = json_decode(request('input_text'), true);
        $length = count($input);

        if ($request->ajax()) {

            request()->validate([
                'title' => 'nullable|string|max:255',
            ]);

            # Count characters based on vendor requirements
            $total_characters = mb_strlen(request('input_text_total'), 'UTF-8');

            if (Auth::user()->group == 'user') {
                if ($total_characters > config('tts.free_chars_limit')) {
                    return response()->json(["error" => __('Total characters of your text is more than allowed, maximum ') . config('tts.free_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            } else {
                if ($total_characters > config('tts.max_chars_limit')) {
                    return response()->json(["error" => __('Total characters of your text is more than allowed, maximum ') . config('tts.max_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            }

            if ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) < $total_characters) {
                return response()->json(["error" => __("Not enough available characters to process")], 422);
            }

            # Variables for recording
            $total_text_raw = '';
            $total_text_characters = 0;
            $inputAudioFiles = [];
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';

            # Audio Format
            if (request('format') == 'mp3') {
                $audio_type = 'audio/mpeg';
            } elseif (request('format') == 'wav') {
                $audio_type = 'audio/wav';
            } elseif (request('format') == 'ogg') {
                $audio_type = 'audio/ogg';
            } elseif (request('format') == 'webm') {
                $audio_type = 'audio/webm';
            }

            # Process each textarea row
            foreach ($input as $key => $value) {

                $total_text_raw .= $value . ' ';
                $voice_id = explode('___', $key);
                $voice = Voice::where('voice_id', $voice_id[0])->first();
                $language = VoiceoverLanguage::where('language_code', $voice->language_code)->first();
                $no_ssml_tags = preg_replace('/<[\s\S]+?>/', '', $value);


                # Count characters based on vendor requirements
                switch ($voice->vendor) {
                    case 'aws':
                        $text_characters = mb_strlen($no_ssml_tags, 'UTF-8');
                        $total_text_characters += $text_characters;
                        break;
                    case 'gcp':
                    case 'ibm':
                        $text_characters = mb_strlen($value, 'UTF-8');
                        $total_text_characters += $text_characters;
                        break;
                    case 'azure':
                        $text_characters = $this->countAzureCharacters($voice, $value);
                        $total_text_characters += $text_characters;
                        break;
                }


                # Check if user has characters available to proceed
                if ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) < $total_characters) {
                    return response()->json(["error" => __("Not enough available characters to process")], 422);
                } else {
                    $this->updateAvailableCharacters($total_characters);
                }


                # Name and extention of the audio file
                if (request('format') == 'mp3') {
                    $file_name = 'LISTEN--' . Str::random(10) . '.mp3';
                } elseif (request('format') == 'ogg') {
                    $file_name = 'LISTEN--' . Str::random(10) . '.ogg';
                } elseif (request('format') == 'webm') {
                    $file_name = 'LISTEN--' . Str::random(10) . '.webm';
                } elseif (request('format') == 'wav') {
                    $file_name = 'LISTEN--' . Str::random(10) . '.wav';
                } else {
                    return response()->json(["error" => __("Unsupported audio file extension was selected")], 422);
                }


                switch ($voice->vendor) {
                    case 'aws':
                        if (request('format') != 'wav' && request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'azure':
                        if (request('format') != 'wav') {
                            $response = $this->processText($voice, $value, request('format'), $file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'gcp':
                        if (request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    case 'ibm':
                        if (request('format') != 'webm') {
                            $response = $this->processText($voice, $value, request('format'), $file_name);
                        } else {
                            continue 2;
                        }
                        break;
                    default:
                        # code...
                        break;
                }


                if ($length == 1) {

                    if (config('tts.default_storage') === 's3') {
                        Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                        $result_url = Storage::disk('s3')->url($file_name);
                        Storage::disk('audio')->delete($file_name);
                    } elseif (config('tts.default_storage') == 'wasabi') {
                        Storage::disk('wasabi')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                        $result_url = Storage::disk('wasabi')->url($file_name);
                        Storage::disk('audio')->delete($file_name);
                    } else {
                        $result_url = Storage::url($file_name);
                    }

                    $result = new VoiceoverResult([
                        'user_id' => Auth::user()->id,
                        'language' => $language->language,
                        'voice' => $voice->voice,
                        'voice_id' => $voice_id[0],
                        'characters' => $text_characters,
                        'voice_type' => $voice->voice_type,
                        'file_name' => $file_name,
                        'text_raw' => $value,
                        'result_ext' => request('format'),
                        'result_url' => $result_url,
                        'audio_type' => $audio_type,
                        'plan_type' => $plan_type,
                        'vendor' => $voice->vendor,
                        'vendor_id' => $voice->vendor_id,
                        'mode' => 'live',
                    ]);

                    $result->save();

                    $data = [];

                    if (request('format') == 'mp3') {
                        $data['audio_type'] = 'audio/mpeg';
                    } elseif (request('format') == 'ogg') {
                        $data['audio_type'] = 'audio/ogg';
                    } elseif (request('format') == 'wav') {
                        $data['audio_type'] = 'audio/wav';
                    } elseif (request('format') == 'webm') {
                        $data['audio_type'] = 'audio/webm';
                    }


                    if (config('tts.default_storage') == 'local')
                        $data['url'] = URL::asset($result_url);
                    else
                        $data['url'] = $result_url;

                    return $data;
                } else {

                    array_push($inputAudioFiles, 'storage/' . $response['name']);

                    $result = new VoiceoverResult([
                        'user_id' => Auth::user()->id,
                        'language' => $language->language,
                        'voice' => $voice->voice,
                        'vendor' => $voice->vendor,
                        'vendor_id' => $voice->vendor_id,
                        'voice_id' => $voice_id[0],
                        'text_raw' => $value,
                        'characters' => $text_characters,
                        'voice_type' => $voice->voice_type,
                        'plan_type' => $plan_type,
                        'mode' => 'hidden',
                    ]);

                    $result->save();
                }
            }

            if ($length > 1) {

                # Name and extention of the main audio file
                if (request('format') == 'mp3') {
                    $file_name = Str::random(10) . '.mp3';
                } elseif (request('format') == 'wav') {
                    $file_name = Str::random(10) . '.wav';
                } elseif (request('format') == 'ogg') {
                    $file_name = Str::random(10) . '.ogg';
                } elseif (request('format') == 'webm') {
                    $file_name = Str::random(10) . '.webm';
                } else {
                    return response()->json(["error" => __("Unsupported audio file extension was selected")], 422);
                }

                $this->merge_files->merge(request('format'), $inputAudioFiles, 'storage/' . $file_name);

                if (config('tts.default_storage') === 's3') {
                    Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                    $result_url = Storage::disk('s3')->url($file_name);
                    Storage::disk('audio')->delete($file_name);
                } elseif (config('tts.default_storage') == 'wasabi') {
                    Storage::disk('wasabi')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                    $result_url = Storage::disk('wasabi')->url($file_name);
                    Storage::disk('audio')->delete($file_name);
                } else {
                    $result_url = Storage::url($file_name);
                }

                $result = new VoiceoverResult([
                    'user_id' => Auth::user()->id,
                    'language' => $language->language,
                    'language_flag' => $language->language_flag,
                    'voice' => $voice->voice,
                    'voice_id' => $voice_id[0],
                    'characters' => $total_text_characters,
                    'voice_type' => 'mixed',
                    'file_name' => $file_name,
                    'text_raw' => $total_text_raw,
                    'result_ext' => request('format'),
                    'result_url' => $result_url,
                    'audio_type' => $audio_type,
                    'plan_type' => $plan_type,
                    'vendor' => $voice->vendor,
                    'vendor_id' => $voice->vendor_id,
                    'mode' => 'live',
                ]);

                $result->save();

                # Clean all temp audio files
                foreach ($inputAudioFiles as $value) {
                    $name_array = explode('/', $value);
                    $name = end($name_array);
                    if (Storage::disk('audio')->exists($name)) {
                        Storage::disk('audio')->delete($name);
                    }
                }

                $data = [];

                if (request('format') == 'mp3') {
                    $data['audio_type'] = 'audio/mpeg';
                } elseif (request('format') == 'ogg') {
                    $data['audio_type'] = 'audio/ogg';
                } elseif (request('format') == 'wav') {
                    $data['audio_type'] = 'audio/wav';
                } elseif (request('format') == 'webm') {
                    $data['audio_type'] = 'audio/webm';
                }


                if (config('tts.default_storage') == 'local')
                    $data['url'] = URL::asset($result->result_url);
                else
                    $data['url'] = $result->result_url;

                return $data;
            }
        }
    }


    /**
     * Process listen synthesize request for a row.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listenRow(Request $request)
    {
        if ($request->ajax()) {

            $input_text = (request('selected_text_length') > 0) ? request('selected_text') : request('row_text');
            $voice = Voice::where('voice_id', request('voice'))->first();
            $language = VoiceoverLanguage::where('language_code', $voice->language_code)->first();
            $no_ssml_tags = preg_replace('/<[\s\S]+?>/', '', $input_text);
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';


            # Count characters based on vendor requirements
            $total_characters = mb_strlen($input_text, 'UTF-8');


            # Count characters based on vendor requirements
            switch ($voice->vendor) {
                case 'aws':
                    $text_characters = mb_strlen($no_ssml_tags, 'UTF-8');
                    break;
                case 'gcp':
                case 'ibm':
                    $text_characters = mb_strlen($input_text, 'UTF-8');
                    break;
                case 'azure':
                    $text_characters = $this->countAzureCharacters($voice, $input_text);
                    break;
            }

            # Limit of Max Chars for synthesizing
            if (Auth::user()->group == 'user') {
                if ($total_characters > config('tts.free_chars_limit')) {
                    return response()->json(["error" => __("Total characters of your text is more than allowed, maximum ") . config('tts.free_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            } else {
                if ($total_characters > config('tts.max_chars_limit')) {
                    return response()->json(["error" => __("Total characters of your text is more than allowed, maximum ") . config('tts.max_chars_limit') . __(" characters allowed. Please decrese the length of your text.")], 422);
                }
            }

            # Maximum supported characters for single synthesize task is 5000 chars
            if ($total_characters > 3000) {
                return response()->json(["error" => __("Too many characters. Maximum 3000 characters are supported for a text synthesize task")], 422);
            }

            # Check if user has characters available to proceed
            if ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) < $total_characters) {
                return response()->json(["error" => __("Not enough available characters to process")], 422);
            } else {
                $this->updateAvailableCharacters($total_characters);
            }


            # Name and extention of the audio file
            if (request('format') == 'mp3') {
                $file_name = 'LISTEN--' . Str::random(20) . '.mp3';
            } elseif (request('format') == 'ogg') {
                $file_name = 'LISTEN--' . Str::random(20) . '.ogg';
            } elseif (request('format') == 'wav') {
                $file_name = 'LISTEN--' . Str::random(20) . '.wav';
            } elseif (request('format') == 'webm') {
                $file_name = 'LISTEN--' . Str::random(20) . '.webm';
            } else {
                return response()->json(["error" => __("Unsupported audio file extension was selected")], 422);
            }


            switch ($voice->vendor) {
                case 'aws':
                    if (request('format') != 'wav' && request('format') != 'webm') {
                        $response = $this->processText($voice, $input_text, request('format'), $file_name);
                    } else {
                        return response()->json(["error" => __("Selected voice supports MP3 and OGG formats. You have selected ") . request('format') .  __(" format. Please change it and try again.")], 422);
                    }
                    break;
                case 'azure':
                    if (request('format') != 'wav') {
                        $response = $this->processText($voice, $input_text, request('format'), $file_name);
                    } else {
                        return response()->json(["error" => __("Selected voice supports MP3, OGG and WEBM formats. You have selected WAV format. Please change it and try again.")], 422);
                    }
                    break;
                case 'gcp':
                    if (request('format') != 'webm') {
                        $response = $this->processText($voice, $input_text, request('format'), $file_name);
                    } else {
                        return response()->json(["error" => __("Selected voice supports MP3, OGG and WAV formats. You have selected WEBM format. Please change it and try again.")], 422);
                    }
                    break;
                case 'ibm':
                    if (request('format') != 'webm') {
                        $response = $this->processText($voice, $input_text, request('format'), $file_name);
                    } else {
                        return response()->json(["error" => __("Selected voice supports MP3, OGG and WAV formats. You have selected WEBM format. Please change it and try again.")], 422);
                    }
                    break;
                default:
                    # code...
                    break;
            }

            if (config('tts.default_storage') === 's3') {
                Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                $result_url = Storage::disk('s3')->url($file_name);
                Storage::disk('audio')->delete($file_name);
            } elseif (config('tts.default_storage') == 'wasabi') {
                Storage::disk('wasabi')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
                $result_url = Storage::disk('wasabi')->url($file_name);
                Storage::disk('audio')->delete($file_name);
            } else {
                $result_url = Storage::url($file_name);
            }

            $result = new VoiceoverResult([
                'user_id' => Auth::user()->id,
                'language' => $language->language,
                'voice' => $voice->voice,
                'voice_id' => $voice->voice_id,
                'characters' => $text_characters,
                'voice_type' => $voice->voice_type,
                'file_name' => $file_name,
                'text_raw' => $input_text,
                'result_ext' => request('format'),
                'result_url' => $result_url,
                'plan_type' => $plan_type,
                'vendor' => $voice->vendor,
                'vendor_id' => $voice->vendor_id,
                'mode' => 'live',
            ]);

            $result->save();


            $data = [];

            if (request('format') == 'mp3') {
                $data['audio_type'] = 'audio/mpeg';
            } elseif (request('format') == 'wav') {
                $data['audio_type'] = 'audio/wav';
            } elseif (request('format') == 'ogg') {
                $data['audio_type'] = 'audio/ogg';
            } elseif (request('format') == 'webm') {
                $data['audio_type'] = 'audio/webm';
            }


            if (config('tts.default_storage') == 'local')
                $data['url'] = URL::asset($result_url);
            else
                $data['url'] = $result_url;

            return $data;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VoiceoverResult $id)
    {
        if ($id->user_id == Auth::user()->id) {

            return view('user.voiceover.show', compact('id'));
        } else {
            return redirect()->route('user.voiceover');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {

            $result = VoiceoverResult::where('id', request('id'))->firstOrFail();

            if ($result->user_id == Auth::user()->id) {

                $result->delete();

                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }


    /**
     * Update user characters number
     */
    private function updateAvailableCharacters($characters)
    {
        $user = User::find(Auth::user()->id);

        if (Auth::user()->available_chars > $characters) {

            $total_chars = Auth::user()->available_chars - $characters;
            $user->available_chars = $total_chars;
        } elseif (Auth::user()->available_chars_prepaid > $characters) {

            $total_chars_prepaid = Auth::user()->available_chars_prepaid - $characters;
            $user->available_chars_prepaid = $total_chars_prepaid;
        } elseif ((Auth::user()->available_chars + Auth::user()->available_chars_prepaid) == $characters) {

            $user->available_chars = 0;
            $user->available_chars_prepaid = 0;
        } else {

            $remaining = $characters - Auth::user()->available_chars;
            $user->available_chars = 0;

            $user->available_chars_prepaid = Auth::user()->available_chars_prepaid - $remaining;
        }

        $user->update();
    }


    /**
     * Update user synthesize task number
     */
    private function updateSynthesizeTasks()
    {
        if (Auth::user()->synthesize_tasks > 0) {
            $user = User::find(Auth::user()->id);
            $user->synthesize_tasks = Auth::user()->synthesize_tasks - 1;
            $user->update();
        }
    }


    /**
     * Count Azure charcters which, some are countes as 2
     */
    private function countAzureCharacters(Voice $voice, $text)
    {
        switch ($voice->language_code) {
            case 'zh-HK':
            case 'zh-CN':
            case 'zh-TW':
            case 'ja-JP':
            case 'ko-KR':
                $total_characters = mb_strlen($text, 'UTF-8') * 2;
                break;
            default:
                $total_characters = mb_strlen($text, 'UTF-8');
                break;
        }

        return $total_characters;
    }


    /**
     * Process text synthesizes based on the vendor/voice selected
     */
    private function processText(Voice $voice, $text, $format, $file_name)
    {
        $aws = new AWSTTSService();
        $gcp = new GCPTTSService();
        $ibm = new IBMTTSService();
        $azure = new AzureTTSService();

        switch ($voice->vendor) {
            case 'aws':
                return $aws->synthesizeSpeech($voice, $text, $format, $file_name);
                break;
            case 'azure':
                return $azure->synthesizeSpeech($voice, $text, $format, $file_name);
                break;
            case 'gcp':
                return $gcp->synthesizeSpeech($voice, $text, $format, $file_name);
                break;
            case 'ibm':
                return $ibm->synthesizeSpeech($voice, $text, $format, $file_name);
                break;
        }
    }


    /**
     * Send settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function config(Request $request)
    {
        if ($request->ajax()) {

            $data['char_limit'] = (auth()->user()->group == 'user') ? config('tts.free_chars_limit') : config('tts.max_chars_limit');
            $data['voice_limit'] = (auth()->user()->group == 'user') ? config('tts.max_voice_limit_user') : config('tts.max_voice_limit');

            return response()->json($data);
        }
    }
}
