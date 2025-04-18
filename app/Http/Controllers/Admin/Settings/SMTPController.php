<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use App\Models\ApplicationConfiguration;
use Illuminate\Support\Facades\Mail;


class SMTPController extends Controller
{
    /**
     * Display SMTP settings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.smtp.index');
    }


    /**
     * Store SMTP settings in env file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'smtp-host' => 'required',
            'smtp-port' => 'required',
            'smtp-username' => 'required',
            'smtp-password' => 'required',
            'smtp-encryption' => 'required',
        ]);

        $this->storeSettings('MAIL_HOST', request('smtp-host'));
        $this->storeSettings('MAIL_PORT', request('smtp-port'));
        $this->storeSettings('MAIL_USERNAME', request('smtp-username'));
        $this->storeSettings('MAIL_PASSWORD', request('smtp-password'));
        $this->storeSettings('MAIL_FROM_ADDRESS', request('smtp-from'));
        $this->storeSettings('MAIL_ENCRYPTION', request('smtp-encryption'));
        $this->storeSettings('MAIL_FROM_NAME', request('smtp-name'));
        cache()->forget('application_configurations');
        return redirect()->back()->with('success', __('SMTP settings successfully updated'));
    }


    /**
     * Send a test email
     */
    public function test(Request $request)
    {
        try {

            Mail::to(request('email'))->send(new TestEmail($request));

            if (Mail::flushMacros()) {
                return redirect()->back()->with('error', 'Test email failed');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Your SMTP settings are not configured correctly yet: ') . $e->getMessage());
        }

        return redirect()->back()->with('success', __('Test email successfully sent'));
    }


    /**
     * Record in .env file
     */
    private function storeSettings($key, $value)
    {
        ApplicationConfiguration::updateOrCreate([
            'configuration_key' => $key
        ], [
            'configuration_value' => $value
        ]);
    }

    private function storeWithQuotes($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . '\'' . env($key) . '\'',
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
