<?php

namespace App\Http\Controllers\User\STT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\AWSSTTService;
use App\Services\GCPSTTService;
use App\Models\TranscribeResult;
use App\Models\User;
use App\Models\TranscribeLanguage;
use App\Models\Project;
use Carbon\Carbon;
use DataTables;
use DB;


class TranscribeStudioController extends Controller
{
    private $api;
    private $aws;
    private $gcp;


    public function __construct()
    {
        $this->api = new LicenseController();
        $this->aws = new AWSSTTService();
        $this->gcp = new GCPSTTService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileTranscribe(Request $request)
    {
        # Today's TTS Results for Datatable
        if ($request->ajax()) {
            $data = TranscribeResult::where('user_id', Auth::user()->id)->where('mode', 'file')->whereDate('created_at', Carbon::today())->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>
                                        <a id="'.$row["id"].'" href="'. route('user.transcribe.show.file', $row['id']) .'" class="transcribeResult"><i class="fa fa-clipboard table-action-buttons view-action-button" title="View Transcript Result"></i></a>
                                        <a class="deleteResultButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Result"></i></a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'd M Y').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-status', function($row){
                        switch ($row['status']) {
                            case 'IN_PROGRESS':
                                $value = 'In Progress';
                                break;
                            case 'FAILED':
                                $value = 'Failed';
                                break;
                            case 'COMPLETED':
                                $value = 'Completed';
                                break;
                            default:
                                $value = '';
                                break;
                        }
                        $custom_voice = '<span class="cell-box transcribe-'.strtolower($row["status"]).'">'.$value.'</span>';
                        return $custom_voice;
                    })
                    ->addColumn('custom-length', function($row){
                        $custom_voice = '<span>'.gmdate("H:i:s", $row['length']).'</span>';
                        return $custom_voice;
                    })
                    ->addColumn('custom-language', function($row) {
                        if (config('stt.vendor_logos') == 'show') {
                            $language = '<span class="vendor-image-sm overflow-hidden"><img alt="vendor" class="mr-2" src="' . URL::asset($row['language_flag']) . '">'. $row['language'] .'<img alt="vendor" class="rounded-circle ml-2" src="' . URL::asset($row['vendor_img']) . '"></span> ';
                        } else {
                            $language = '<span class="vendor-image-sm overflow-hidden"><img alt="vendor" class="mr-2" src="' . URL::asset($row['language_flag']) . '">'. $row['language'] .'</span> ';
                        }
                        return $language;
                    })
                    ->addColumn('download', function($row){
                        $result = '<a class="result-download" href="' . $row['file_url'] . '" download title="Download Audio"><i class="fa fa-cloud-download table-action-buttons download-action-button"></i></a>';
                        return $result;
                    })
                    ->addColumn('single', function($row){
                        $result = '<button type="button" class="result-play pl-0" title="Play Audio" onclick="resultPlay(this)" src="' . $row['file_url'] . '" type="'. $row['audio_type'].'" id="'. $row['id'] .'"><i class="fa fa-play table-action-buttons view-action-button"></i></button>';
                        return $result;
                    })
                    ->addColumn('result', function($row){
                        $result = $row['file_url'];
                        return $result;
                    })
                    ->addColumn('type', function($row){
                        $result = ($row['speaker_identity'] == 'true') ? 'Speaker Identification' : 'Standard';
                        return $result;
                    })
                    ->rawColumns(['actions', 'created-on', 'custom-status', 'custom-length', 'custom-language', 'result', 'download', 'single', 'type'])
                    ->make(true);

        }


        $languages = DB::table('transcribe_languages')
                ->join('vendors', 'transcribe_languages.vendor', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', 1)
                ->where('transcribe_languages.status', 'active')
                ->orWhere(function($query) {
                    $query->where('transcribe_languages.type', 'file')
                          ->where('transcribe_languages.type', 'both');
                })
                ->select('transcribe_languages.id', 'transcribe_languages.language', 'transcribe_languages.language_code', 'transcribe_languages.language_flag', 'transcribe_languages.vendor_img')
                ->orderBy('transcribe_languages.language', 'asc')
                ->get();

        $projects = Project::where('user_id', auth()->user()->id)->orderBy('name', 'asc')->get();

        return view('user.transcribe.file', compact('languages', 'projects'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recordTranscribe(Request $request)
    {
        # Today's TTS Results for Datatable
        if ($request->ajax()) {
            $data = TranscribeResult::where('user_id', Auth::user()->id)->where('mode', 'record')->whereDate('created_at', Carbon::today())->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>
                                        <a id="'.$row["id"].'" href="'. route('user.transcribe.show.record', $row['id']) .'" class="transcribeResult"><i class="fa fa-clipboard table-action-buttons view-action-button" title="View Transcript Result"></i></a>
                                        <a class="deleteResultButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Result"></i></a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'd M Y').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-status', function($row){
                        switch ($row['status']) {
                            case 'IN_PROGRESS':
                                $value = 'In Progress';
                                break;
                            case 'FAILED':
                                $value = 'Failed';
                                break;
                            case 'COMPLETED':
                                $value = 'Completed';
                                break;
                            default:
                                $value = '';
                                break;
                        }
                        $custom_voice = '<span class="cell-box transcribe-'.strtolower($row["status"]).'">'.$value.'</span>';
                        return $custom_voice;
                    })
                    ->addColumn('custom-length', function($row){
                        $custom_voice = '<span>'.gmdate("H:i:s", $row['length']).'</span>';
                        return $custom_voice;
                    })
                    ->addColumn('custom-language', function($row) {
                        if (config('stt.vendor_logos') == 'show') {
                            $language = '<span class="vendor-image-sm overflow-hidden"><img alt="vendor" class="mr-2" src="' . URL::asset($row['language_flag']) . '">'. $row['language'] .'<img alt="vendor" class="rounded-circle ml-2" src="' . URL::asset($row['vendor_img']) . '"></span> ';
                        } else {
                            $language = '<span class="vendor-image-sm overflow-hidden"><img alt="vendor" class="mr-2" src="' . URL::asset($row['language_flag']) . '">'. $row['language'] .'</span> ';
                        }
                        return $language;
                    })
                    ->addColumn('download', function($row){
                        $result = '<a class="result-download" href="' . $row['file_url'] . '" download title="Download Audio"><i class="fa fa-cloud-download table-action-buttons download-action-button"></i></a>';
                        return $result;
                    })
                    ->addColumn('single', function($row){
                        $result = '<button type="button" class="result-play pl-0" title="Play Audio" onclick="resultPlay(this)" src="' . $row['file_url'] . '" type="'. $row['audio_type'].'" id="'. $row['id'] .'"><i class="fa fa-play table-action-buttons view-action-button"></i></button>';
                        return $result;
                    })
                    ->addColumn('result', function($row){
                        $result = $row['file_url'];
                        return $result;
                    })
                    ->addColumn('type', function($row){
                        $result = ($row['speaker_identity'] == 'true') ? 'Speaker Identification' : 'Standard';
                        return $result;
                    })
                    ->rawColumns(['actions', 'created-on', 'custom-status', 'custom-length', 'result', 'custom-language', 'download', 'single', 'type'])
                    ->make(true);

        }

        # Set Voice Types as Listed in TTS Config
        $languages = DB::table('transcribe_languages')
                ->join('vendors', 'transcribe_languages.vendor', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', 1)
                ->where('transcribe_languages.status', 'active')
                ->orWhere(function($query) {
                    $query->where('transcribe_languages.type', 'file')
                          ->where('transcribe_languages.type', 'both');
                })
                ->select('transcribe_languages.id', 'transcribe_languages.language', 'transcribe_languages.language_code', 'transcribe_languages.language_flag', 'transcribe_languages.vendor_img')
                ->orderBy('transcribe_languages.language', 'asc')
                ->get();

        $projects = Project::where('user_id', auth()->user()->id)->orderBy('name', 'asc')->get();

        return view('user.transcribe.record', compact('languages', 'projects'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function liveTranscribe(Request $request)
    {
        # Today's STT Results for Datatable
        if ($request->ajax()) {
            $data = TranscribeResult::where('user_id', Auth::user()->id)->where('mode', 'live')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>
                                        <a id="'.$row["id"].'" href="#" class="transcribeResult"><i class="fa fa-clipboard table-action-buttons view-action-button" title="Transcript Result"></i></a>
                                        <a class="deleteResultButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Result"></i></a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'Y-m-d H:i:s').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-length', function($row){
                        $custom_voice = '<span>'.gmdate("H:i:s", $row['length']).'</span>';
                        return $custom_voice;
                    })
                    ->addColumn('custom-language', function($row) {
                        $language = '<span class="vendor-image-sm overflow-hidden"><img alt="vendor" class="mr-2" src="' . URL::asset($row['language_flag']) . '">'. $row['language'] .'</span> ';
                        return $language;
                    })
                    ->rawColumns(['actions', 'created-on', 'custom-length', 'custom-language'])
                    ->make(true);

        }

        # Show Languages
        $languages = DB::table('transcribe_languages')
                ->join('vendors', 'transcribe_languages.vendor', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', 1)
                ->where('transcribe_languages.status', 'active')
                ->where('type', 'both')
                ->select('transcribe_languages.id', 'transcribe_languages.language', 'transcribe_languages.language_code', 'transcribe_languages.language_flag', 'transcribe_languages.vendor_img')
                ->orderBy('id', 'asc')
                ->get();

        $projects = Project::where('user_id', auth()->user()->id)->orderBy('name', 'asc')->get();

        return view('user.transcribe.live', compact('languages', 'projects'));
    }


    /**
     * Process audio transcribe request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transcribe(Request $request)
    {  
        if ($request->ajax()) {

            request()->validate([
                'audiofile' => 'required',
                'language' => 'required',
                'identify' => 'nullable',
                'speakers' => 'nullable',
            ]);

            if (request()->hasFile('audiofile')) {

                $file = request()->file('audiofile');
                $extension = (request('extension')) ? 'wav' : $file->extension();
                $original_name = (request('extension')) ? 'Recording' : $file->getClientOriginalName();
                $size = $file->getSize();

                if (!request('extension')) {
                    if ($size > (config('stt.max_size_limit') * 1048576)) {
                        return response()->json(["error" => __('File is too large, maximum allowed file size is: ') . config('stt.max_size_limit') . 'MB'], 422);
                    }

                    if (auth()->user()->group == 'user') {
                        if ((request('audiolength') / 60) > config('stt.max_length_limit_file_none')) {
                            return response()->json(["error" => __('Audio length is too long, maximum allowed audio file length is: ') . config('stt.max_length_limit_file') . __(' minutes')], 422);
                        }
                    } else {
                        if ((request('audiolength') / 60) > config('stt.max_length_limit_file')) {
                            return response()->json(["error" => __('Audio length is too long, maximum allowed audio file length is: ') . config('stt.max_length_limit_file') . __(' minutes')], 422);
                        }
                    }


                } else {
                    if (auth()->user()->group == 'user') {
                        if ((request('audiolength') / 60) > config('stt.max_length_limit_file_none')) {
                            return response()->json(["error" => __('Audio length is too long, maximum allowed audio file length is: ') . config('stt.max_length_limit_file') . __(' minutes')], 422);
                        }
                    } else {
                        if ((request('audiolength') / 60) > config('stt.max_length_limit_file')) {
                            return response()->json(["error" => __('Audio length is too long, maximum allowed audio file length is: ') . config('stt.max_length_limit_file') . __(' minutes')], 422);
                        }
                    }
                }

            }

            $language = TranscribeLanguage::where('id', request('language'))->first();
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';
            $job_name = strtoupper(Str::random(10));
            $mode = (request('extension')) ? 'record' : 'file';
            $file_size = $this->formatBytes($size);

            # GCP check if not mp3
            if ($language->vendor == 'gcp_audio' && $extension == 'mp3') {
                return response()->json(["error" => __("GCP languages do not support MP3 audio file format. Use FLAC or WAC formats")], 422);
            }

            # Count minutes based on vendor requirements
            $audio_length = (request('audiolength') / 60);
            $audio_length = number_format((float)$audio_length, 3, '.', '');

            # Check if user has minutes available to proceed
            if ((Auth::user()->available_minutes + Auth::user()->available_minutes_prepaid) < $audio_length) {
                return response()->json(["error" => __("Not enough available minutes to process. Subscribe or Top up to get more")], 422);
            } else {
                $this->updateAvailableMinutes($audio_length);
            }

            # Name and extention of the result audio file
            if ($extension === 'mp3') {
                $file_name = $job_name . '.mp3';
            } elseif ($extension === 'mp4')  {
                $file_name = $job_name .'.mp4';
            } elseif ($extension === 'ogg')  {
                $file_name = $job_name .'.ogg';
            } elseif ($extension === 'flac')  {
                $file_name = $job_name .'.flac';
            } elseif ($extension === 'webm') {
                $file_name = $job_name .'.webm';
            } elseif ($extension === 'wav') {
                $file_name = $job_name .'.wav';
            } else {
                return response()->json(["error" => __("Unsupported audio file extension was selected. Please try again")], 422);
            }

            # Audio Format
            if ($extension == 'mp3') {
                $audio_type = 'audio/mpeg';
            } elseif ($extension == 'mp4') {
                $audio_type = 'audio/mp4';
            } elseif ($extension == 'flac') {
                $audio_type = 'audio/flac';
            } elseif ($extension == 'ogg') {
                $audio_type = 'audio/ogg';
            } elseif($extension == 'wav') {
                $audio_type = 'audio/wav';
            } elseif($extension == 'webm') {
                $audio_type = 'audio/webm';
            }

            \Log::info($file);
            \Log::info(file_get_contents($file));
            if ($language->vendor === 'aws_audio') {
                Storage::disk('s3')->put('aws/' . $file_name, file_get_contents($file));
                $file_url = Storage::disk('s3')->url('aws/' . $file_name);
            } elseif ($language->vendor == 'gcp_audio') {
                $file_url = $file;
                \Log::info($file);
                \Log::info($file_url);
            }


            $response = $this->processAudio($language, $job_name, $extension, request('audiolength'), $audio_type, request('taskType'), $file_url, $file, request('identify'), request('speakers'),);


            if ($language->vendor == 'aws_audio') {
                if ($response != 'success') {
                    return response()->json(["error" => __("Transcribe Task was not created properly. Please try again")], 422);
                }
            } elseif ($language->vendor == 'gcp_audio') {
                if ($response['status'] != 'success') {
                    return response()->json(["error" => __("Transcribe Task was not created properly. ") . $response['message']], 422);
                }
            }


            if ($language->vendor == 'aws_audio') {
                $result = new TranscribeResult([
                    'user_id' => Auth::user()->id,
                    'language' => $language->language,
                    'language_flag' => $language->language_flag,
                    'file_url' => $file_url,
                    'file_size' => $file_size,
                    'file_name' => $original_name,
                    'format' => $extension,
                    'storage' => $language->vendor,
                    'task_id' => $job_name,
                    'vendor_img' => $language->vendor_img,
                    'vendor' => $language->vendor,
                    'length' => request('audiolength'),
                    'plan_type' => $plan_type,
                    'audio_type' => $audio_type,
                    'status' => 'IN_PROGRESS',
                    'mode' => $mode,
                    'project' => request('project'),
                    'speaker_identity' => request('identify')
                ]);

            } elseif ($language->vendor == 'gcp_audio') {

                $words = count(preg_split('/\s+/', strip_tags($response['transcript'])));
                $supported = [67, 78, 85, 88, 89, 95, 100, 109, 111, 129, 133, 154];

                if (in_array($language->id, $supported)) {
                    $showSpeakers = request('identify');
                } else {
                    $showSpeakers = 'false';
                }

                $raw = ($response['raw']) ? $response['raw'] : '';

                $result = new TranscribeResult([
                    'user_id' => Auth::user()->id,
                    'language' => $language->language,
                    'language_flag' => $language->language_flag,
                    'file_url' => $response['url'],
                    'file_size' => $file_size,
                    'file_name' => $original_name,
                    'format' => $extension,
                    'storage' => $language->vendor,
                    'task_id' => $job_name,
                    'vendor_img' => $language->vendor_img,
                    'vendor' => $language->vendor,
                    'length' => request('audiolength'),
                    'plan_type' => $plan_type,
                    'audio_type' => $audio_type,
                    'status' => $response['job_status'],
                    'text' => $response['transcript'],
                    'words' => $words,
                    'raw' => $raw,
                    'gcp_task' => $response['gcp_task'],
                    'mode' => $mode,
                    'project' => request('project'),
                    'speaker_identity' => $showSpeakers,
                ]);
            }


            $result->save();

            return response()->json(["success" => __("Transcribe task was submitted successfully")], 200);

        }
    }


    /**
     * Process live transcribe request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transcribeLive(Request $request)
    {
        if ($request->ajax()) {
            $language = TranscribeLanguage::where('id', request('language'))->first();
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';
            $job_name = strtoupper(Str::random(10));
            $words = count(preg_split('/\s+/', strip_tags(request('text'))));

            # Count minutes based on vendor requirements
            $audio_length = (request('audiolength') / 60);
            $audio_length = number_format((float)$audio_length, 3, '.', '');

            if ($language->vendor == 'aws_audio') {
                $result = new TranscribeResult([
                    'user_id' => Auth::user()->id,
                    'language' => $language->language,
                    'language_flag' => $language->language_flag,
                    'task_id' => $job_name,
                    'vendor_img' => $language->vendor_img,
                    'vendor' => $language->vendor,
                    'words' => $words,
                    'text' => request('text'),
                    'length' => request('audiolength'),
                    'plan_type' => $plan_type,
                    'status' => 'COMPLETED',
                    'mode' => 'live',
                    'project' => request('project'),
                ]);

                $result->save();
            }


            # Check if user has minutes available to proceed
            if ((Auth::user()->available_minutes + Auth::user()->available_minutes_prepaid) < $audio_length) {
                $this->updateAvailableMinutes($audio_length);
                return response()->json(["error" => __("Your minutes are now depleted. Subscribe or Top up to get more!")], 422);
            } else {
                $this->updateAvailableMinutes($audio_length);
            }

            return response()->json(["success" => __("Success! Transcribe task was stored successfully")], 200);

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFile(TranscribeResult $id)
    {
        if ($id->user_id == auth()->user()->id) {

            $end_time = gmdate("H:i:s", $id->length);

            $data['type'] = json_encode($id->speaker_identity);
            $data['raw'] = json_encode($id->raw);
            $data['text'] = json_encode($id->text);
            $data['url'] = json_encode($id->file_url);
            $data['vendor'] = json_encode($id->vendor);
            $data['end_time'] = json_encode($end_time);

            $task_type = ($id->speaker_identity == 'true') ? 'Speaker Identification' : 'Standard';

            return view('user.transcribe.show-file', compact('id', 'data', 'task_type'));
        }

        return redirect()->route('user.transcribe.file');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRecord(TranscribeResult $id)
    {
        if ($id->user_id == auth()->user()->id) {

            $end_time = gmdate("H:i:s", $id->length);

            $data['type'] = json_encode($id->speaker_identity);
            $data['raw'] = json_encode($id->raw);
            $data['text'] = json_encode($id->text);
            $data['url'] = json_encode($id->file_url);
            $data['vendor'] = json_encode($id->vendor);
            $data['end_time'] = json_encode($end_time);

            $task_type = ($id->speaker_identity == 'true') ? 'Speaker Identification' : 'Standard';

            return view('user.transcribe.show-record', compact('id', 'data', 'task_type'));
        }

        return redirect()->route('user.transcribe.record');
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
     * Process audio files based on the vendor language selected
     */
    private function processAudio(TranscribeLanguage $language, $job_name, $extension, $duration, $audio_type, $task_type, $file_url = null, $file = null, $identify = null, $speakers = null)
    {
        switch($language->vendor) {
            case 'aws_audio':
                return $this->aws->startTask($language, $job_name, $identify, $speakers, $extension, $file_url);
                break;
            case 'gcp_audio':
                return $this->gcp->startTask($language, $job_name, $extension, $file, $duration, $audio_type, $task_type, $identify, $speakers);
                break;
        }
    }


    public function settings(Request $request)
    {
        $formats = explode(',', config('stt.file_format'));
        $string = [];
        $list = '';

        foreach($formats as $format) {
            $value = trim($format);
            switch ($value) {
                case 'mp3':
                    array_push($string, "audio/mpeg");
                    $list .=' MP3,';
                    break;
                case 'mp4':
                    array_push($string, "audio/mp4");
                    $list .=' MP4,';
                    break;
                case 'flac':
                    array_push($string, "audio/flac");
                    $list .=' FLAC,';
                    break;
                case 'ogg':
                    array_push($string, "audio/ogg");
                    $list .=' Ogg,';
                    break;
                case 'wav':
                    array_push($string, "audio/wav");
                    $list .=' WAV';
                    break;
                case 'webm':
                    array_push($string, "audio/webm");
                    $list .=' WebM,';
                    break;
                default:
                    break;
            }
        }

        if ($request->ajax()) {
            $data['size'] = config('stt.max_size_limit');
            $data['length_file'] = (auth()->user()->group == 'user') ? config('stt.max_length_limit_file_none') : config('stt.max_length_limit_file');
            $data['length_live'] = (auth()->user()->group == 'user') ? config('stt.max_length_limit_live_none') : config('stt.max_length_limit_live');
            $data['type'] = $string;
            $data['type_show'] = $list;
            return $data;
        }
    }


    public function settingsLive(Request $request)
    {
        if ($request->ajax()) {
            $data['region'] = config('services.aws.region');
            $data['ak'] = config('services.aws.key');
            $data['sak'] = config('services.aws.secret');
            $data['limit'] = auth()->user()->available_minutes;

            return $data;
        }
    }


    public function settingsLiveLimits(Request $request)
    {
        if ($request->ajax()) {
            $data['limits'] = auth()->user()->available_minutes;

            return $data;
        }
    }


    public function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
