<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Events\RegistrationReferrerBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $information_rows = ['title', 'author', 'keywords', 'description', 'css', 'js'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        return view('auth.register', compact('information'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'country' => 'required',
            'agreement' => 'required',
            'username' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
        ]);
        try {
            if (config('services.google.recaptcha.enable') == 'on') {

                $recaptchaResult = $this->reCaptchaCheck(request('recaptcha'));

                if ($recaptchaResult->success != true) {
                    return redirect()->back()->with('error', __('Google reCaptcha Validation has Failed'));
                }

                if ($recaptchaResult->score >= 0.5) {

                    $this->createNewUser($request);

                    if (config('settings.email_verification') == 'enabled') {
                        return redirect()->route('login')->with('success', __('Final step! Email verification link has been sent to you'));
                    } else {
                        return redirect()->route('login')->with('success', __('Congratulation! You can now proceed to login with your email'));
                    }
                } else {
                    return redirect()->back()->with('error', __('Google reCaptcha Validation has Failed'));
                }
            } else {


                $this->createNewUser($request);

                if (config('settings.email_verification') == 'enabled') {
                    return redirect()->route('login')->with('success', __('Final step! Email verification link has been sent to you'));
                } else {
                    return redirect()->route('login')->with('success', __('Congratulation! You can now proceed to login with your email'));
                }
            }
        } catch (\Exception $th) {
            return redirect()->back()->with('error', __('Something went wrong. Try again after sometime.'));
        }
    }

    /**
     * Create new user
     *
     */
    public function createNewUser(Request $request)
    {

        $vlippr_oauth = $this->create_user_on_cloud($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'language' => config('tts.default_language'),
            'voice' => config('tts.default_voice'),
            'job_role' => 'Happy Person',
            'language_file' => config('stt.language.file'),
            'language_live' => config('stt.language.live'),
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'vlippr_oauth' => $vlippr_oauth,
        ]);

        event(new Registered($user));

        $referral_code = ($request->hasCookie('referral')) ? $request->cookie('referral') : '';
        $referrer = ($referral_code != '') ? User::where('referral_id', $referral_code)->firstOrFail() : '';
        $referrer_id = ($referrer != '') ? $referrer->id : '';

        $status = (config('settings.email_verification') == 'disabled') ? 'active' : 'pending';
        if (!isset($request->user_type) || $request->user_type != 'voice-artist') {
            $user->assignRole(config('settings.default_user'));
            $user->group = config('settings.default_user');
        } else {
            $user->assignRole('voice-artist');
            $user->group = 'voice-artist';
        }
        $user->status = $status;

        $user->available_chars = config('tts.free_chars');
        $user->available_minutes = config('stt.free_minutes');
        $user->referral_id = strtoupper(Str::random(15));
        $user->referred_by = $referrer_id;
        $user->save();

        Auth::login($user);
    }


    /**
     * Validate reCaptcha (if enabled)
     *
     */
    private function reCaptchaCheck($recaptcha)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $data = [
            'secret' => config('services.google.recaptcha.secret_key'),
            'response' => $recaptcha,
            'remoteip' => $remoteip
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        return $resultJson;
    }

    public function create_user_on_cloud(Request $request)
    {

        $createApiUrl = config('app.vaanee_api_endpoint') . 'user_create/';

        $client = new Client();
        $postData = [
            "email" => $request->email,
            "fullname" => $request->name,
            "username" => $request->username,
            "youtube_url" => "https://www.youtube.com/watch?v=RFEKXonWRAI",
            "password" => $request->password,
            "phone_number" => $request->phone_number,
            "category" => "video",
            "tnc" => true
        ];
        $response = $client->post($createApiUrl, [
            'json' => $postData,
        ]);


        return get_user_access_token_and_refresh_token($request);
    }
}
