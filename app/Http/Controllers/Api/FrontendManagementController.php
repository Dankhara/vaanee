<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Blog;
use App\Models\Career;
use App\Models\UseCase;
use App\Models\Review;
use App\Models\Page;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FrontendManagementController extends Controller
{
    /**
     * Get Frontend Setting
     */
    public function getFrontendSetting()
    {
        $files_rows = ['css', 'js'];
        $files = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $files_rows)) {
                $files[$row['name']] = $row['value'];
            }
        }

        $files['landing_page_url'] = env('FRONTEND_CUSTOM_URL_LINK');
        $files['facebook_url'] = env('FRONTEND_SOCIAL_FACEBOOK');
        $files['twitter_url'] = env('FRONTEND_SOCIAL_TWITTER');
        $files['linkedin_url'] = env('FRONTEND_SOCIAL_LINKEDIN');
        $files['instagram_url'] = env('FRONTEND_SOCIAL_INSTAGRAM');

        return response()->json([
            "message" => "Settings",
            "data" => [$files],
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Seo And Logo
     */
    public function getSeoAndLogo()
    {
        $information_rows = ['title', 'author', 'keywords', 'description'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }
        $information['primary_logo'] = 'img/brand/logo.png';
        $information['footer_logo'] = 'img/brand/logo-white.png';
        $information['minimized_logo'] = 'img/brand/favicon.png';
        $information['favicon_logo'] = 'img/brand/favicon.ico';

        return response()->json([
            "message" => "Seo And Logo",
            "data" => [$information],
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Blog
     */
    public function getBlogs()
    {
        $blogs = Blog::all();

        return response()->json([
            "message" => "Blog",
            "data" => $blogs,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Faqs
     */
    public function getFaqs()
    {
        $faqs = Faq::get();

        return response()->json([
            "message" => "Faq",
            "data" => $faqs,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Use Cases
     */
    public function getUseCases()
    {
        $useCases = UseCase::all();

        return response()->json([
            "message" => "UseCaces",
            "data" => $useCases,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Customer reviews
     */
    public function getCustomerReviews()
    {
        $reviews = Review::get();

        return response()->json([
            "message" => "Reviews",
            "data" => $reviews,
            "success_status" => true,
            "status" => 200
        ]);
    }



    /**
     * Get Privacy page
     */
    public function getPrivacyPage()
    {
        $page = Page::where('name', 'privacy')->first();


        return response()->json([
            "message" => "Pages",
            "data" => $page,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Terms page
     */
    public function getTermPage()
    {

        $page = Page::where('name', 'terms')->first();

        return response()->json([
            "message" => "Pages",
            "data" => $page,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Cookies page
     */
    public function getCookiePage()
    {

        $page = Page::where('name', 'cookies_policy')->first();

        return response()->json([
            "message" => "Pages",
            "data" => $page,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Customer reviews
     */
    public function getLanguages()
    {
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

        return response()->json([
            "message" => "Languages",
            "data" => $languages,
            "success_status" => true,
            "status" => 200
        ]);
    }


    /**
     * Get Customer reviews
     */
    public function getVoices()
    {
        $voices = DB::table('voices')
            ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
            ->where('vendors.enabled', '1')
            ->where('voices.voice_type', 'neural')
            ->where('voices.status', 'active')
            ->orderBy('voices.vendor', 'asc')
            ->get();

        return response()->json([
            "message" => "Voices",
            "data" => $voices,
            "success_status" => true,
            "status" => 200
        ]);
    }

    /**
     * Get Careers
     */
    public function getCareers()
    {
        $careers = Career::all();

        return response()->json([
            "message" => "Career",
            "data" => $careers,
            "success_status" => true,
            "status" => 200
        ]);
    }
}
