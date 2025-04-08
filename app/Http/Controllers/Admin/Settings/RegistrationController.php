<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ApplicationConfiguration;

class RegistrationController extends Controller
{
    /**
     * Display registration settings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.registration.index');
    }


    /**
     * Store registration settings in env file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'registration' => 'required',
            'email-verification' => 'required',
        ]);

        if (request('country')) {
            // $newName = "'" . request('country') . "'";
            // $this->storeWithQuotes('GENERAL_SETTINGS_DEFAULT_COUNTRY', $newName);
            $this->storeSettings('GENERAL_SETTINGS_DEFAULT_COUNTRY', request('country'));
        }

        $this->storeSettings('GENERAL_SETTINGS_REGISTRATION', request('registration'));
        $this->storeSettings('GENERAL_SETTINGS_EMAIL_VERIFICATION', request('email-verification'));
        cache()->forget('application_configurations');

        return redirect()->back()->with('success', __('Registration settings successfully updated'));
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
        ApplicationConfiguration::updateOrCreate([
            'configuration_key' => $key
        ], [
            'configuration_value' => $value
        ]);
    }
}
