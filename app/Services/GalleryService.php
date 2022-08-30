<?php 
namespace App\Services;

/*Interfaces */
use App\Interfaces\ServiceInterface;

/*Traits */
use App\Traits\UploadTrait;

/*request */
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

/* models */ 
use App\Models\Gallery;

/* helpers */
use Storage;

class GalleryService implements ServiceInterface {

    use UploadTrait;

    public function store(StoreProductRequest $request, integer $id) : void {
        
            foreach ($request->gallery as $key => $image) {
                $imageName = $this->upload($request);

                
                $gallery = Gallery::create([
                    'product_id' => $id,
                    'image' => $imageName,
                ]);
            }
        }

    public function delete(integer $id) : void {
        $gallery = Gallery::where('product_id', $id)->get();

        if ($gallery) {
            foreach ($gallery as $img) {
                $img->delete();
                Storage::delete('/images/' . $img);
            }
        }
    }
    
}