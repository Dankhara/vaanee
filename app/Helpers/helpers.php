<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getAccessToken')) {
    function getAccessToken()
    {
        try {
            $oauthToken = auth()->user()->vlippr_oauth;
            if ($oauthToken) {
                $oauthTokens = json_decode($oauthToken, true);
                $refreshToken = $oauthTokens['refresh_token'];
                return get_access_token_from_refresh_token($refreshToken);
            } else {
                // Auth::logout();
                // request()->session()->invalidate();

                // request()->session()->regenerateToken();

                // return redirect('/');
            }
            // $filePath = storage_path('app/refresh_token.txt');
            // if (file_exists($filePath)) {
            //     $refreshToken = file_get_contents($filePath);
            //     return get_access_token_from_refresh_token($refreshToken);
            // } else {
            //     $responseData = get_access_token_and_refresh_token();
            //     $refreshToken = $responseData['refresh_token'];
            //     file_put_contents($filePath, $refreshToken);
            //     return $responseData['access_token'];
            // }
        } catch (\Exception $e) {
            // Auth::logout();
            // request()->session()->invalidate();

            // request()->session()->regenerateToken();

            // return redirect('/');
        }
    }
}

// if (!function_exists('getAccessToken')) {
//     function getAccessToken()
//     {
//         $apiUrl = 'http://um-wm-dev.ap-south-1.elasticbeanstalk.com/api/user/refresh/';
//         $client = new Client();
//         $postData = [
//             'refresh_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiMDllNTMzNDctMDgzMS00ZGU4LWJmZjktOGI5ZDEzM2QyNTU0IiwidG9rZW5fdHlwZSI6InJlZnJlc2giLCJleHAiOjE3MDY0NjIzNTZ9.lh-GM72TUUqu2LuioZHrVskk3NkWjxvjsjxgEUZ6vIM',
//         ];

//         try {
//             // Make a POST request to the API
//             $response = $client->post($apiUrl, [
//                 'json' => $postData,
//             ]);


//             // Get the response body as a string
//             $responseBody = $response->getBody()->getContents();

//             return json_decode($responseBody)->access_token;
//         } catch (\Exception $e) {
//             // Handle any exceptions that may occur
//             return response()->json(['error' => $e->getMessage()], 500);
//         }
//     }
// }

if (!function_exists('getLanguageByAudio')) {
    function getLanguageByAudio($url)
    {
        return pathinfo(explode('_', basename($url))[2])['filename'];
    }
}

function get_access_token_from_refresh_token($refreshToken)
{
    $apiUrl = config('app.vaanee_api_endpoint') . 'api/user/refresh/';
    $client = new Client();
    $postData = [
        'refresh_token' => $refreshToken,
    ];
    $response = $client->post($apiUrl, [
        'json' => $postData,
    ]);
    $responseBody = $response->getBody()->getContents();
    $responseJson = json_decode($responseBody);
    if($responseJson->success){
        return $responseJson->result->access_token;
    }else{
        return false;
    }
}

function get_access_token_and_refresh_token()
{
    $apiUrl = config('app.vaanee_api_endpoint') . 'api/user/login/';
    $client = new Client();
    $postData = [
        'username' => 'svcvn@vlippr.com',
        'password' => 'svcvn'
    ];
    $response = $client->post($apiUrl, [
        'json' => $postData,
    ]);
    $responseBody = $response->getBody()->getContents();
    $responseData = json_decode($responseBody);
    return [
        'access_token' => $responseData->access_token,
        'refresh_token' => $responseData->access_token
    ];
}

function get_user_access_token_and_refresh_token(Request $request)
{

    try {
        $apiUrl = config('app.vaanee_api_endpoint') . 'api/user/login/';
        $client = new Client();
        $postData = [
            'username' => $request->email,
            'password' => $request->password
        ];
        $response = $client->post($apiUrl, [
            'json' => $postData,
        ]);

        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody);
        return json_encode($responseData->result);
    } catch (\Throwable $th) {
        return null;
    }
}
