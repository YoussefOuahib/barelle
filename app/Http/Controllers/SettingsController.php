<?php

namespace App\Http\Controllers;

/*Traits */
use App\Traits\UploadTrait;

/*Request */
use Illuminate\Http\Request;
use App\Http\Requests\StoreSettingRequest;

/*Resources */
use App\Http\Resources\SettingsResource;

/*Models */
use App\Models\Setting;

/*Helpers */
use Carbon\Carbon;
use Image;

class SettingsController extends Controller
{
    public function store(StoreSettingRequest $request)
    {
        $logo = Carbon::now()->timestamp . '.' . $request->logo->extension();
        $location = public_path('storage/images/' . $logo);
        Image::make($request->logo)->resize(600, 600)->save($location);

        
        $setting = Setting::updateOrCreate([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'map' => $request->map,
            'header_text' => $request->header_text,
            'newsletter_header' => $request->newsletter_header,
            'newsletter_text' => $request->newsletter_text,
            'email' => $request->email,
            'footer_description' => $request->footer_description,
            'logo' => $logo,
        ]);
        return response()->json(['status' => 201]);
    }

    public function index()
    {
        $settings = Setting::first();
        return response([
            'settings' => new SettingsResource($settings),
        ], 201);
    }
}
