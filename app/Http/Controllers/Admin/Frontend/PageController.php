<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $information_rows = ['cookies_policy', 'privacy', 'terms'];
        $information = [];
        $pages = Page::all();

        foreach ($pages as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        return view('admin.frontend.page.index', compact('information'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'privacy' => 'nullable',
            'terms' => 'nullable',
            'cookies_policy' => 'nullable'
        ]);

        $rows = ['privacy', 'terms', 'cookies_policy'];
        foreach ($rows as $row) {
            $page_exists = Page::where('name', $row)->first();
            if ($page_exists) {
                Page::where('name', $row)->update([
                    'value' => $request->input($row)
                ]);
            } else {
                $page = new Page;
                $page->name = $row;
                $page->value = $request->input($row);
                $page->save();
            }
        }

        return redirect()->back()->with('success', __('Content successfully saved'));
    }
}
