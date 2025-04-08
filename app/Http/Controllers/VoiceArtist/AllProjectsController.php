<?php

namespace App\Http\Controllers\VoiceArtist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllProjectsController extends Controller
{
    public function show_all_projects()
    {
        return view('voice-artist.projects.all-projects');
    }
}
