<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Studio;
use App\Models\User;
use App\Models\Music;
use App\Models\VoiceCloning;
use GuzzleHttp\Client;
use Yajra\DataTables\DataTables;

class SoundStudioSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # Today's TTS Results for Datatable
        if ($request->ajax()) {
            $data = Studio::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                            <a href="' . route("admin.sound.studio.show", $row["id"]) . '"><i class="fa-solid fa-list-music table-action-buttons view-action-button" title="Download Audio File"" title="View Result"></i></a>
                                            <a class="deleteResultButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Download Audio File"" title="Delete Result"></i></a>
                                        </div>';
                    return $actionBtn;
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span>' . date_format($row["created_at"], 'd M Y') . '</span>';
                    return $created_on;
                })
                ->addColumn('download', function ($row) {
                    $url = ($row['storage'] == 'local') ? URL::asset($row['url']) : $row['url'];
                    $result = '<a class="" href="' . $url . '" download><i class="fa fa-cloud-download table-action-buttons download-action-button" title="Download Audio File"></i></a>';
                    return $result;
                })
                ->addColumn('single', function ($row) {
                    $url = ($row['storage'] == 'local') ? URL::asset($row['url']) : $row['url'];
                    $result = '<button type="button" class="result-play" onclick="resultPlay(this)" src="' . $url . '" id="' . $row['id'] . '"><i class="fa fa-play table-action-buttons view-action-button" title="Play Audio File"></i></button>';
                    return $result;
                })
                ->addColumn('custom-extension', function ($row) {
                    $language = '<span class="font-weight-bold">' . $row['format'] . '</span> ';
                    return $language;
                })
                ->addColumn('username', function ($row) {
                    $username = '<span>' . User::find($row["user_id"])->name . '</span>';
                    return $username;
                })
                ->rawColumns(['actions', 'created-on', 'download', 'single', 'custom-extension', 'username'])
                ->make(true);
        }

        return view('admin.studio.soundstudio.index');
    }

    public function voiceCloning()
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
        $languages = isset($langs->result[0]->supported_languages) ? $langs->result[0]->supported_languages : '';



        if (request()->ajax()) {
            $data = VoiceCloning::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }


        return view('admin.studio.soundstudio.voice-cloning', compact('languages'));
    }

    public function createVoiceCloning(Request $request)
    {
        VoiceCloning::create($request->all());
        return back()->with('success', 'Voice Cloning successfully done.');
    }

    public function music(Request $request)
    {
        # Today's TTS Results for Datatable
        if ($request->ajax()) {
            $data = Music::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                        <a class="makePublicButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-check table-action-buttons request-action-button" title="Make Public"></i></a>
                                        <a class="makePrivateButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-ban table-action-buttons view-action-button" title="Make Private"></i></a>
                                        <a class="deleteMusicButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Audio File"></i></a>
                                    </div>';
                    return $actionBtn;
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span>' . date_format($row["created_at"], 'd M Y') . '</span>';
                    return $created_on;
                })
                ->addColumn('custom-size', function ($row) {
                    $size = $this->formatBytes((int)$row['size']);
                    return $size;
                })
                ->addColumn('download', function ($row) {
                    $url = URL::asset($row['url']);
                    $result = '<a class="" href="' . $url . '" download><i class="fa fa-cloud-download table-action-buttons download-action-button" title="Download Audio File"></i></a>';
                    return $result;
                })
                ->addColumn('play', function ($row) {
                    $type = ($row['type'] == 'mp3') ? 'audio/mpeg' : 'audio/ogg';
                    $url = URL::asset($row['url']);
                    $result = '<button type="button" class="result-play" onclick="resultPlay(this)" src="' . $url . '" type="' . $type . '" id="' . $row['id'] . '"><i class="fa fa-play table-action-buttons view-action-button" title="Play Audio File"></i></button>';
                    return $result;
                })
                ->addColumn('status', function ($row) {
                    if ($row['public']) {
                        $status = '<span><i class="fa-solid fa-check text-success" title="Public Background Audio File"></i></span>';
                    } else {
                        $status = '<span><i class="fa-solid fa-ban text-danger" title="Private Background Audio File"></i></span>';
                    }
                    return $status;
                })
                ->addColumn('username', function ($row) {
                    $username = '<span>' . User::find($row["user_id"])->name . '</span>';
                    return $username;
                })
                ->rawColumns(['actions', 'created-on', 'download', 'play', 'custom-size', 'status', 'username'])
                ->make(true);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'size' => 'required|integer|min:0',
            'files' => 'required|integer|max:20|min:0',
            'windows-path' => 'nullable',
        ]);

        $this->storeConfiguration('CONFIG_MAX_BACKGROUND_AUDIO_SIZE', request('size'));
        $this->storeConfiguration('CONFIG_MAX_MERGE_FILES', request('files'));
        $this->storeConfiguration('CONFIG_ENABLE_SOUND_STUDIO', request('enable-sound-studio'));
        $this->storeConfiguration('CONFIG_WINDOWS_FFMPEG_PATH', request('windows-path'));
        cache()->forget('application_configurations');

        return redirect()->back()->with('success', __('Settings were successfully updated'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Studio $id)
    {
        return view('admin.studio.soundstudio.show', compact('id'));
    }


    /**
     * Upload background music file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $status = false;

        if (request()->hasFile('audiofile')) {

            $file = request()->file('audiofile');
            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $size = $file->getSize();

            $audio_length = gmdate("H:i:s", request('audiolength'));

            $folder = '/uploads/music/';
            $file_name = Str::random(10) . '.' . $extension;
            $url = $folder . $file_name;

            $file->storeAs($folder, $file_name, 'public');

            $result = new Music([
                'user_id' => Auth::user()->id,
                'url' => $url,
                'type' => $extension,
                'size' => $size,
                'duration' => $audio_length,
                'name' => $name,
                'public' => true,
            ]);

            $result->save();

            $status = true;
        }

        if ($request->ajax()) {
            $data = ($status) ? true : false;
            return $data;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteResult(Request $request)
    {
        if ($request->ajax()) {

            $result = Studio::where('id', request('id'))->firstOrFail();

            if ($result) {

                $result->delete();

                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMusic(Request $request)
    {
        if ($request->ajax()) {

            $result = Music::where('id', request('id'))->firstOrFail();

            if ($result) {

                Storage::disk('public')->delete($result->url);

                $result->delete();

                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }


    /**
     * Set background music as public.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function public(Request $request)
    {
        if ($request->ajax()) {

            $result = Music::where('id', request('id'))->firstOrFail();

            if ($result->user_id == Auth::user()->id) {

                if ($result->public == true) {
                    return response()->json('error');
                } else {
                    $result->public = true;
                    $result->save();

                    return response()->json('success');
                }
            } else {
                return response()->json('error');
            }
        }
    }


    /**
     * Set background music as private.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function private(Request $request)
    {
        if ($request->ajax()) {

            $result = Music::where('id', request('id'))->firstOrFail();

            if ($result->user_id == Auth::user()->id) {

                if ($result->public == false) {
                    return response()->json('error');
                } else {
                    $result->public = false;
                    $result->save();

                    return response()->json('success');
                }
            } else {
                return response()->json('error');
            }
        }
    }


    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    /**
     * Record in .env file
     */
    private function storeConfiguration($key, $value)
    {
        ApplicationConfiguration::updateOrCreate([
            'configuration_key' => $key
        ], [
            'configuration_value' => $value
        ]);
        // $path = base_path('.env');

        // if (file_exists($path)) {

        //     file_put_contents($path, str_replace(
        //         $key . '=' . env($key),
        //         $key . '=' . $value,
        //         file_get_contents($path)
        //     ));
        // }
    }
}
