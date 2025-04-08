<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Review;
use DataTables;

class ReviewController extends Controller
{
    /**
     * Show appearance settings page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::all()->sortByDesc("created_at");
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                            <a href="' . route("admin.settings.review.edit", $row["id"]) . '"><i class="fa-solid fa-pencil-square table-action-buttons edit-action-button" title="Edit Review"></i></a>
                                            <a class="deleteReviewButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Review"></i></a>
                                        </div>';
                    return $actionBtn;
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span>' . date_format($row["created_at"], 'd M Y H:i:s') . '</span>';
                    return $created_on;
                })
                ->rawColumns(['actions', 'created-on'])
                ->make(true);
        }

        return view('admin.frontend.review.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.review.create');
    }


    /**
     * Store review post properly in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'designation' => 'required',
            'company_name' => 'required',
            'rating' => 'required',
            'image' => 'required',
            'company_logo' => 'required',
            'text' => 'required',
        ]);
        $customer_image_url = null;
        $company_logo_url = null;
        if (request()->has('image')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('image');
            $name = Str::random(10) . time();
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $customer_image_url = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        }

        if (request()->has('company_logo')) {

            request()->validate([
                'company_logo' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('company_logo');
            $name = Str::random(10) . time();
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $company_logo_url = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        }

        Review::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'company_name' => $request->company_name,
            'rating' => $request->rating,
            'company_logo_url' => $request->company_logo_url,
            'customer_image_url' => $customer_image_url,
            'text' => $request->text,
        ]);

        return redirect()->route('admin.settings.review')->with('success', __('Review successfully created'));
    }


    /**
     * Edit review.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $id)
    {
        return view('admin.frontend.review.edit', compact('id'));
    }


    /**
     * Update review post properly in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
            'designation' => 'required',
            'company_name' => 'required',
            'rating' => 'required',
            'text' => 'required',
        ]);

        if (request()->has('image')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('image');
            $name = Str::random(10);
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $customer_image_url = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        } else {
            $customer_image_url = '';
        }

        if (request()->has('company_logo_url')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);

            $image = request()->file('company_logo_url');
            $name = Str::random(10);
            $folder = 'img/reviews/';

            $this->uploadImage($image, $folder, 'public', $name);

            $company_logo_url = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        } else {
            $company_logo_url = '';
        }

        $review = Review::where('id', $id)->firstOrFail();
        $review->name = request('name');
        $review->customer_image_url = ($customer_image_url != '') ? $customer_image_url : $review->customer_image_url;
        $review->company_logo_url = ($company_logo_url != '') ? $company_logo_url : $review->company_logo_url;
        $review->designation = request('designation');
        $review->company_name = request('company_name');
        $review->rating = request('rating');
        $review->text = request('text');
        $review->save();

        return redirect()->route('admin.settings.review')->with('success', __('Review successfully updated'));
    }


    /**
     * Upload logo images
     */
    public function uploadImage(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(5);

        $file->storeAs($folder, $name . '.' . $file->getClientOriginalExtension(), $disk);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {

            $review = Review::find(request('id'));

            if ($review) {

                $review->delete();

                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }
}
