<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BannerCollection;
use App\Http\Resources\BannerResource;
use App\Http\Requests\StoreBannerRequest;

use App\Models\Banner;
use Carbon\Carbon;
use Image;
class BannerController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum','admin'])->except(['index']);
      }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        
        $picture = Carbon::now()->timestamp.'.'.$request->picture->extension();

        $request->picture->move(public_path('storage/banners'), $picture);
      if($request->order > 10){
          return response()->json([
              'message' => "there's only 9 banners"
          ]);
      }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $imageName = $banner->picture;
        
       
        if($request->file('picture')){
        $imageName = Carbon::now()->timestamp.'.'. $request->picture->extension();
        
        $request->picture->move(public_path('banners'), $picture);
     
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
