<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use App\Services\Statistics\UserPaymentsService;
use App\Services\Statistics\UserUsageYearlyService;
use App\Services\Statistics\UserUsageMonthlyService;
use App\Models\Subscriber;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Project;
use App\Models\Voice;
use App\Models\VoiceoverLanguage;
use App\Models\TranscribeLanguage;
use App\Models\UserVoiceOver;
use App\Models\UserVoiceProfileScript;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use DataTables;
use Exception;

class UserDashboardController extends Controller
{
    use Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $payments_yearly = new UserPaymentsService($year);
        $usage_yearly = new UserUsageYearlyService($year);
        $usage_monthly = new UserUsageMonthlyService($month, $year);

        $user_data_month = [
            'total_standard_chars' => $usage_monthly->getTotalStandardCharsUsage(),
            'total_neural_chars' => $usage_monthly->getTotalNeuralCharsUsage(),
            'total_minutes' => $usage_monthly->getTotalMinutes(),
            'total_audio_files' => $usage_monthly->getTotalTranscribeInputs()
        ];

        $user_data_year = [
            'total_payments' => $payments_yearly->getTotalPayments(auth()->user()->id),
            'total_standard_chars' => $usage_yearly->getTotalStandardCharsUsage(auth()->user()->id),
            'total_neural_chars' => $usage_yearly->getTotalNeuralCharsUsage(auth()->user()->id),
            'total_audio_files' => $usage_yearly->getTotalAudioFiles(auth()->user()->id),
            'total_listen_modes' => $usage_yearly->getTotalListenModes(auth()->user()->id),
            'total_minutes' => $usage_yearly->getTotalMinutes(auth()->user()->id),
            'total_words' => $usage_yearly->getTotalWords(auth()->user()->id),
            'total_file_transcribe' => $usage_yearly->getTotalFileTranscribe(auth()->user()->id),
            'total_recording_transcribe' => $usage_yearly->getTotalRecordingTranscribe(auth()->user()->id),
            'total_live_transcribe' => $usage_yearly->getTotalLiveTranscribe(auth()->user()->id),
        ];

        $chart_data['payments'] = json_encode($payments_yearly->getPayments(auth()->user()->id));
        $chart_data['standard_chars'] = json_encode($usage_yearly->getStandardCharsUsage(auth()->user()->id));
        $chart_data['neural_chars'] = json_encode($usage_yearly->getNeuralCharsUsage(auth()->user()->id));
        $chart_data['file_minutes'] = json_encode($usage_yearly->getFileMinutesUsage(auth()->user()->id));
        $chart_data['record_minutes'] = json_encode($usage_yearly->getRecordMinutesUsage(auth()->user()->id));
        $chart_data['live_minutes'] = json_encode($usage_yearly->getLiveMinutesUsage(auth()->user()->id));

        if (auth()->user()->hasActiveSubscription()) {
            $subscription = Subscriber::where('user_id', auth()->user()->id)->where('status', 'Active')->first();
        } else {
            $subscription = false;
        }

        $user_subscription = ($subscription) ? SubscriptionPlan::where('id', auth()->user()->plan_id)->first() : '';

        $characters = auth()->user()->available_chars;
        $minutes = auth()->user()->available_minutes;

        if ($subscription) {
            $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
            $total_characters = $plan->characters;
            $total_minutes = $plan->minutes;
        } else {
            $total_characters = config('tts.free_chars');
            $total_minutes = config('tts.free_minutes');
        }

        $voiceover_voice = Voice::where('voice_id', auth()->user()->voice)->select('voice')->get();
        $voiceover_language = VoiceoverLanguage::where('language_code', auth()->user()->language)->select('language')->get();
        $transcribe_language = TranscribeLanguage::where('id', auth()->user()->language_file)->select('language')->get();

        $progress = [
            'characters' => ($total_characters > 0) ? ((auth()->user()->available_chars / $total_characters) * 100) : 0,
            'minutes' => ($total_minutes > 0) ? ((auth()->user()->available_minutes / $total_minutes) * 100) : 0,
        ];

        // $languages = DB::table('voices')
        //     ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
        //     ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
        //     ->where('vendors.enabled', '1')
        //     ->where('voices.status', 'active')
        //     ->where('voices.voice_type', 'neural')
        //     ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
        //     ->distinct()
        //     ->orderBy('voiceover_languages.language', 'asc')
        //     ->get();

        $projects = Project::where('user_id', auth()->user()->id)->orderBy('name', 'asc')->get();
        // $voices = Voice::where('voice_type', 'custome')->latest()->first();
        $vprojects = [];
        try {
            $client = new Client();
            $yourAccessToken = getAccessToken();
            $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/project/', [
                // You can customize the request further, such as adding headers
                'headers' => [
                    'Authorization' => 'Bearer ' . $yourAccessToken,
                ],
            ]);

            $vprojects = json_decode($response->getBody()->getContents())->result;

        } catch (Exception $ex) {
            \Log::info('Project not found');
        }
        
        $count_projects = count($vprojects);
        $user_voice_profile_script_found = UserVoiceProfileScript::where('user_id', auth()->id())->count();

        return view(
            'user.dashboard.index',
            compact(
                'subscription',
                'chart_data',
                'user_data_year',
                'user_subscription',
                'characters',
                'total_characters',
                'progress',
                'minutes',
                'total_minutes',
                'user_data_month',
                'voiceover_voice',
                'voiceover_language',
                'transcribe_language',
                // 'languages',
                'projects',
                // 'voices',
                'count_projects',
                'user_voice_profile_script_found'
            )
        );
    }


    public function projects(Request $request)
    {
        # Today's TTS Results for Data table
        if ($request->ajax()) {
            $video_projects = [];
            try {
                $client = new Client();
                $yourAccessToken = getAccessToken();
                $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/project/', [
                    // You can customize the request further, such as adding headers
                    'headers' => [
                        'Authorization' => 'Bearer ' . $yourAccessToken,
                    ],
                ]);

                $projects = json_decode($response->getBody()->getContents());
                
                foreach ($projects->result as $value) {
                    $video_projects[] = $value;
                }
                cache(['video_projects' => $video_projects]);
            } catch (Exception $ex) {
                cache(['video_projects' => $video_projects]);
            }
            $video_projects = cache('video_projects');
            return Datatables::of(collect($video_projects))
                ->addIndexColumn()
                ->addColumn('project_name', function ($row) {
                    return $row->project_name ?? '';
                })
                ->addColumn('project_type', function ($row) {
                    return $row->project_type ?? '';
                })
                ->addColumn('created_on', function ($row) {
                    return date('d-m-Y h:i A', strtotime($row->created_on)) ?? '';
                    // return $row->created_on ?? '';
                })
                ->addColumn('status', function ($row) {
                    return $row->status ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('user.video.show-project', [$row->project_id, $row->project_type]) . '"><i class="fa-solid fa-eye table-action-buttons edit-action-button" title="View Result"></i></a>';
                })
                ->filter(function ($instance) use ($request) {

                    if (isset($request->status)) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['status'], $request->get('status')) ? true : false;
                        });
                    }
                    if (isset($request->type)) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['project_type'], $request->get('type')) ? true : false;
                        });
                    }
                })
                ->rawColumns(['project_name', 'project_type', 'created_on', 'status', 'actions'])
                ->make(true);
        }
        
        return view('user.dashboard.projects');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        return view('user.dashboard.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProject($id = null, $projectType = 'video')
    {

        $project = [];
        try {
            $client = new Client();
            $yourAccessToken = getAccessToken();
            $response = $client->get(config('app.vaanee_api_endpoint') . 'vaanee/project/' . $id . '/', [
                // You can customize the request further, such as adding headers
                'headers' => [
                    'Authorization' => 'Bearer ' . $yourAccessToken,
                ],
            ]);

            $project = json_decode($response->getBody()->getContents())->result;

            if ($project->video_url && $project->status == 'done') {
                return view('user.dashboard.show-project', compact('project'));
            }
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
            return view(
                'user.voiceover.video-dub-studio',
                compact(
                    'models',
                    // 'voices',
                    'languages',
                    'projectType',
                    'project'
                )
            );
        } catch (Exception $ex) {
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

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'neural')
                ->where('voices.status', 'active')
                ->orderBy('voices.voice_type', 'desc')
                ->orderBy('voices.voice', 'asc')
                ->get();
            return view(
                'user.dashboard.edit-project-details',
                compact(
                    'models',
                    'voices',
                    'languages',
                    'projectType'
                )
            );
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDefaults($id = null)
    {
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
                ->orderBy('voices.vendor', 'asc')
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
                ->orderBy('voices.vendor', 'asc')
                ->get();
        } else {
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
                ->orderBy('voices.vendor', 'asc')
                ->get();
        }

        $languages_file = DB::table('transcribe_languages')
            ->where('type', 'file')
            ->orWhere('type', 'both')
            ->where('status', 'active')
            ->orderBy('language', 'asc')
            ->get();

        $languages_live = DB::table('transcribe_languages')
            ->orWhere('type', 'both')
            ->where('status', 'active')
            ->orderBy('language', 'asc')
            ->get();

        $projects = Project::where('user_id', auth()->user()->id)->get();

        return view('user.dashboard.update', compact('languages', 'voices', 'projects', 'languages_live', 'languages_file'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $user->update(request()->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'job_role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'phone_number' => 'nullable|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]));

        if (request()->has('profile_photo')) {

            try {
                request()->validate([
                    'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048'
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'PHP FileInfo: ' . $e->getMessage());
            }

            $image = request()->file('profile_photo');

            $name = Str::random(20);

            $folder = '/uploads/img/users/';

            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadImage($image, $folder, 'public', $name);

            $user->profile_photo_path = $filePath;

            $user->save();
        }

        return redirect()->route('user.dashboard.edit', compact('user'))->with('success', __('Profile was successfully updated'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDefaults(User $user)
    {
        $user->update(request()->validate([
            'voice' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'project' => 'nullable|string|max:255',
            'language_file' => 'nullable',
            'language_live' => 'nullable',
        ]));


        $user->save();


        return redirect()->route('user.dashboard.edit.defaults', compact('user'))->with('success', __('Default settings successfully updated'));
    }

    public function storeVoiceOver()
    {
        request()->validate([
            'username' => 'required',
        ]);

        if (!request()->hasFile('voice-file')) {
            // Storage::disk('s3')->put('aws/' . $file_name, file_get_contents($file));
            // $file_url = Storage::disk('s3')->url('aws/kjkjkjk.wav');
            $file_url = request()->file('audiofile')->store('public');
        } else {
            $file_url = request()->file('voice-file')->store('public');
        }

        $result = new Voice([
            'user_id' => Auth::user()->id,
            'sample_url' => Storage::url($file_url),
            // 'file_size' => $file_size,
            'voice_type' => 'custome',
            'voice' => request()->username,
            // 'length' => request('audiolength'),
            'voice_id' => 'own-language',
            // 'audio_type' => $audio_type,
            'status' => 'deactive',
            'vendor_id' => 'own-voice',
            'vendor' => 'own',
            'vendor_img' => '/img/csp/user.png',
            'gender' => request()->gender,
            'language_code' => request()->language_code,
        ]);


        $result->save();
        return back()->with('success', __('Profile was successfully updated'));
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    /**
     * Update user minutes
     */
    private function updateAvailableMinutes($minutes)
    {
        $user = User::find(Auth::user()->id);

        if (Auth::user()->available_minutes > $minutes) {

            $total_minutes = Auth::user()->available_minutes - $minutes;
            $user->available_minutes = $total_minutes;
        } elseif (Auth::user()->available_minutes_prepaid > $minutes) {

            $total_minutes_prepaid = Auth::user()->available_minutes_prepaid - $minutes;
            $user->available_minutes_prepaid = $total_minutes_prepaid;
        } elseif ((Auth::user()->available_minutes + Auth::user()->available_minutes_prepaid) == $minutes) {

            $user->available_minutes = 0;
            $user->available_minutes_prepaid = 0;
        } else {

            $remaining = $minutes - Auth::user()->available_minutes;
            $user->available_minutes = 0;

            $user->available_minutes_prepaid = Auth::user()->available_minutes_prepaid - $remaining;
        }

        $user->update();
    }



    /**
     * Upload user profile image
     */
    public function uploadImage(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $image = $file->storeAs($folder, $name . '.' . $file->getClientOriginalExtension(), $disk);

        return $image;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function project(Request $request)
    {
        if ($request->ajax()) {
            request()->validate([
                'new-project' => 'required'
            ]);

            if (strtolower(request('new-project') == 'all')) {
                return response()->json(['status' => 'error', 'message' => __('Project Name is reserved and is already created, please create another one')]);
            }

            $check = Project::where('user_id', auth()->user()->id)->where('name', request('new-project'))->first();

            if (!isset($check)) {
                $project = new Project([
                    'user_id' => auth()->user()->id,
                    'name' => htmlspecialchars(request('new-project'))
                ]);

                $project->save();

                return response()->json(['status' => 'success', 'message' => __('Project has been successfully created')]);
            } else {
                return response()->json(['status' => 'error', 'message' => __('Project name already exists')]);
            }
        }
    }
}
