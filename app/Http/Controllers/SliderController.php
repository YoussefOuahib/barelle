<?php

namespace App\Http\Controllers;

/*Traits */
use App\Traits\UploadTrait;

/*Requests */
use Illuminate\Http\Request;

/*Collections & Resources */
use App\Http\Resources\SliderCollection;
use App\Http\Resources\SliderResource;

/*Models */
use App\Models\Slider;

/*Helpers */
use Carbon\Carbon;
use Image;

class SliderController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::paginate(10);
        return new SliderCollection($sliders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = $this->upload($request);

        $slider = Slider::create([
            "title" => $request->title,
            "link" => $request->link,
            "picture" => $imageName,
           
        ]);
        return (new SliderResource($slider))->additional([
            'status' => 201
        ]);

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return new SliderResource($slider);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
       
        if($request->file('picture')){
            $imageName = $this->upload($request);
        }
        $slider->update([
            "title" => $request->title,
            "link" => $request->link,
            "picture" => $imageName,
        ]);
        return response()->json(['status' => 201]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        $this->deleteimage($slider->picture);


    }
}
