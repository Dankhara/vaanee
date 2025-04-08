<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Career::all()->sortByDesc("created_at");
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = 'Active';
                    if ($row['status'] != 1) {
                        $status = 'Inactive';
                    }
                    return $status;
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                            <a href="' . route("admin.settings.careers.edit", $row["id"]) . '"><i class="fa-solid fa-pencil-square table-action-buttons edit-action-button" title="Edit Job"></i></a>
                                            <a class="deleteCareerButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Job"></i></a>
                                        </div>';
                    return $actionBtn;
                })
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage') . '/' . $row['image'];
                    return '<img src="' . $imagePath . '" width="50%">';
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span>' . date_format($row["created_at"], 'd M Y H:i:s') . '</span>';
                    return $created_on;
                })
                ->rawColumns(['actions', 'created-on', 'image'])
                ->make(true);
        }

        return view('admin.frontend.careers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.careers.create');
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
            'job_position' => 'required',
            'job_description' => 'required',
            'job_category' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'salary_type' => 'required',
            'no_of_positions' => 'required',
            'education' => 'required',
            'job_type' => 'required',
            'duration' => 'required',
        ]);
        $image_path = null;
        if (request()->has('image')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('image');
            $name = Str::random(10) . time();
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $image_path = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        }
        Career::create([
            'job_position' => request()->job_position,
            'job_description' => request()->job_description,
            'image' => $image_path,
            'job_category' => request()->job_category,
            'start_date' => request()->start_date,
            'end_date' => request()->end_date,
            'salary' => request()->salary,
            'salary_type' => request()->salary_type,
            'no_of_positions' => request()->no_of_positions,
            'education' => request()->education,
            'job_type' => request()->job_type,
            'duration' => request()->duration,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.settings.careers.index')->with('success', __('Job successfully created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $careerDetails = Career::findOrFail($id);
        return view('admin.frontend.careers.edit', compact('careerDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'job_position' => 'required',
            'job_description' => 'required',
            'job_category' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'salary_type' => 'required',
            'no_of_positions' => 'required',
            'education' => 'required',
            'job_type' => 'required',
            'duration' => 'required',
        ]);
        $image_path = null;
        if (request()->has('image')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('image');
            $name = Str::random(10) . time();
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $image_path = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        }
        $careerDetails = Career::where('id', $id)->firstOrFail();
        $careerDetails->job_position = request('job_position');
        $careerDetails->image = ($image_path != '') ? $image_path : $careerDetails->image;
        $careerDetails->job_description = request('job_description');
        $careerDetails->job_category = request()->job_category;
        $careerDetails->start_date = request()->start_date;
        $careerDetails->end_date = request()->end_date;
        $careerDetails->salary = request()->salary;
        $careerDetails->salary_type = request()->salary_type;
        $careerDetails->no_of_positions = request()->no_of_positions;
        $careerDetails->education = request()->education;
        $careerDetails->job_type = request()->job_type;
        $careerDetails->duration = request()->duration;
        $careerDetails->updated_at = now();
        $careerDetails->save();
        return redirect()->route('admin.settings.careers.index')->with('success', __('Job successfully updated'));
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {

            $career = Career::find(request('id'));

            if ($career) {

                $career->delete();

                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadImage(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(5);

        $file->storeAs($folder, $name . '.' . $file->getClientOriginalExtension(), $disk);
    }
}
