<?php

namespace App\Http\Controllers\VoiceArtist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyProjectsController extends Controller
{
    public function show_my_projects()
    {
        return view('voice-artist.projects.my-projects');
    }
}
