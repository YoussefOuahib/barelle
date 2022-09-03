<?php
namespace App\Traits;

/*helpers */
use Image;
use Carbon\Carbon;
use Storage;

trait UploadTrait {
    public function upload($request) : string {
        $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
        $location = public_path('storage/images/' . $imageName);
        Image::configure(array('driver' => 'imagick'));
        Image::make($request->image)->resize(600, 600)->save($location);

        return $imageName;
    }
    public function deleteimage($image) : void {
        Storage::delete('/images/' . $image);
    } 
}

