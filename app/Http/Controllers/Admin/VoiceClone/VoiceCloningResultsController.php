<?php

namespace App\Http\Controllers\Admin\VoiceClone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoiceCloningResultsController extends Controller
{
    public function voice_cloning_results(Request $request)
    {
        return view('admin.voice-clone.voice-cloning-results');
    }
}
