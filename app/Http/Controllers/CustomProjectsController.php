<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomProjectsController extends Controller
{
    // Method for storing custom project data in API Server
    public function store(Request $request)
    {
        // Validating User Response
        $validated = $request->validate([
            'custom_project_title' => "required|max:255"
        ]);

        $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/project/';
        $client = new Client();
        $postData = [
            'project_name' => $validated['custom_project_title'] ?? '',
            'project_type' => 'custom',
            'modal' => 'model_1',
            'video_format' => 'm3u8',
            'downloadable' => 'yes',
        ];

        $yourAccessToken = getAccessToken();

        // try {
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

        $responseArray = json_decode($responseBody, true);

        // Check if decoding was successful
        if ($responseArray !== null) {
            // Add more keys to the array
            $responseArray['name'] = $validated['custom_project_title'];
            // Add as many keys as you want

            // If you need to work with the modified data in JSON format, re-encode it to JSON
            $modifiedResponseBody = json_encode($responseArray);


        } else {
            // Handle JSON decode error, if necessary
        }

        Session::flash("success", "Custom Project Created Successfully !");

        return view("user.custom-projects.index")->with(compact("modifiedResponseBody"));

        // } catch (\Exception $e) {
        //     dd("error");
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    }
    public function index()
    {
        // Return Default View
        return view("user.custom-projects.index");
    }
}
