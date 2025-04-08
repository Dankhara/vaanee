<?php

namespace App\Http\Controllers\Admin\VoiceClone;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\URL;

class VoiceCloningProfileController extends Controller
{
    public function voice_cloning_profiles(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = User::latest()->get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('actions', function ($row) {
        //             $actionBtn = '<div>
        //                                 <a href="' . route("admin.user.storage", $row["id"]) . '"><i class="fa-sharp fa-solid fa-music table-action-buttons request-action-button" title="Listen"></i></a>
        //                                 <a class="deleteUserButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-user-slash table-action-buttons delete-action-button" title="Delete"></i></a>
        //                             </div>';
        //             return $actionBtn;
        //         })
        //         ->addColumn('user', function ($row) {
        //             if ($row['profile_photo_path']) {
        //                 $path = asset($row['profile_photo_path']);
        //                 $user = '<div class="d-flex">
        //                             <div class="widget-user-image-sm overflow-hidden mr-4"><img alt="Avatar" src="' . $path . '"></div>
        //                             <div class="widget-user-name"><span class="font-weight-bold">' . $row['name'] . '</span><br><span class="text-muted">' . $row["email"] . '</span></div>
        //                         </div>';
        //             } else {
        //                 $path = URL::asset('img/users/avatar.png');
        //                 $user = '<div class="d-flex">
        //                             <div class="widget-user-image-sm overflow-hidden mr-4"><img alt="Avatar" class="rounded-circle" src="' . $path . '"></div>
        //                             <div class="widget-user-name"><span class="font-weight-bold">' . $row['name'] . '</span><br><span class="text-muted">' . $row["email"] . '</span></div>
        //                         </div>';
        //             }

        //             return $user;
        //         })
        //         ->addColumn('created-on', function ($row) {
        //             $created_on = '<span class="font-weight-bold">' . date_format($row["created_at"], 'd M Y') . '</span>';
        //             return $created_on;
        //         })
        //         ->addColumn('last-seen-on', function ($row) {
        //             $last_seen = '<span class="font-weight-bold">' . \Carbon\Carbon::parse($row['last_seen'])->format('d M Y') . '</span>';
        //             return $last_seen;
        //         })
        //         ->addColumn('custom-status', function ($row) {
        //             $custom_status = '<span class="cell-box user-' . $row["status"] . '">' . ucfirst($row["status"]) . '</span>';
        //             return $custom_status;
        //         })
        //         ->addColumn('custom-group', function ($row) {
        //             $custom_group = '<span class="cell-box user-group-' . $row["group"] . '">' . ucfirst($row["group"]) . '</span>';
        //             return $custom_group;
        //         })
        //         ->addColumn('custom-country', function ($row) {
        //             $custom_country = '<span class="font-weight-bold">' . $row["country"] . '</span>';
        //             return $custom_country;
        //         })
        //         ->addColumn('custom-characters', function ($row) {
        //             $custom_characters = '<span class="font-weight-bold">' . number_format($row["available_chars"] + $row['available_chars_prepaid'], 0, 2) . '</span>';
        //             return $custom_characters;
        //         })
        //         ->addColumn('custom-minutes', function ($row) {
        //             $custom_minutes = '<span class="font-weight-bold">' . number_format($row["available_minutes"] + $row['available_minutes_prepaid'], 0, 2) . '</span>';
        //             return $custom_minutes;
        //         })
        //         ->rawColumns(['actions', 'custom-status', 'custom-group', 'created-on', 'user', 'custom-country', 'custom-characters', 'custom-minutes', 'last-seen-on'])
        //         ->make(true);
        // }

        return view('admin.voice-clone.voice-cloning-profile');
    }
}
