<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Carbon\Carbon;
use App\Http\Resources\SettingsResource;
use App\Http\Resources\SettingsCollection;
use Image;
class SettingsController extends Controller
{
    public function store(Request $request) {
        if($request->logo) {
        $logo = Carbon::now()->timestamp.'.'.$request->logo->extension();

        $location = public_path('storage/products/' . $logo);
        Image::make($request->logo)->resize(500,200)->save($location);

        }
        else {
        $logo;
        }
         $setting = Setting::updateOrCreate([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'logo' => $logo,
            'map' => $request->map,
            'header_text' => $request->header_text,
            'footer_description' => $request->footer_description,
            'newsletter_header' => $request->newsletter_header,
            'newsletter_text' => $request->newsletter_text,

        ]);
        return response()->json(['status' => 201]);

    }
    public function index() {
        $settings = Setting::first();
        return response([
            'settings' => new SettingsResource($settings),
         

        ], 201);
    }
}
