<?php

namespace App\Http\Controllers;

/*Traits */
use App\Traits\UploadTrait;

/*Requests */
use Illuminate\Http\Request;
use App\Http\Requests\StoreBannerRequest;

/*Collections & Resources */
use App\Http\Resources\BannerCollection;
use App\Http\Resources\BannerResource;

/*Models */
use App\Models\Banner;

/*Helpers */
use Carbon\Carbon;
use Image;


class BannerController extends Controller
{

    use UploadTrait;
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('order','ASC')->paginate(10);
        return new BannerCollection($banners);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        
        $picture = $this->upload($request);

     
        $banner = Banner::create([
            "title" => $request->title,
            "link" => $request->link,
            "picture" => $picture,
            "order" => $request->order,
        ]);
        return (new BannerResource($banner))->additional([
            'status' => 201
        ]);
    }
    public function goUp(Banner $banner)
    {
        $prevbanner = Banner::where('order', $banner->order - 1)->first();

        $prevbanner->update([
            'order' => $banner->order,
        ]);
        $banner->update([
            'order' => $banner->order - 1,
        ]);
        
       return (new BannerResource($banner))->additional([
        'status' => 201,
      
    ]);

    }
    public function goDown(Banner $banner)
    {
        $prevbanner = Banner::where('order', $banner->order + 1)->first();

        $prevbanner->update([
            'order' => $banner->order,
        ]);
        $banner->update([
            'order' => $banner->order + 1,
        ]);
        
       return (new BannerResource($banner))->additional([
        'status' => 201,
      
    ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        
       
        if($request->file('picture')){
            $imageName = $this->upload($request);
     
        }
        $banner->update([
            "title" => $request->title,
            "link" => $request->link,
            "picture" => $imageName,
            "order" => $request->order,
        ]);

        return response()->json(['status' => 201]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        $this->deleteimage($banner->picture);
    }
}
