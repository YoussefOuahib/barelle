<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SliderCollection;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Carbon\Carbon;
use Image;
class SliderController extends Controller
{
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
    public function store(Request $request)
    {
        $picture = Carbon::now()->timestamp.'.'.$request->picture->extension();
                

        $request->picture->move(public_path('storage/sliders'), $picture);
      
        $slider = Slider::create([
            "title" => $request->title,
            "link" => $request->link,
            "picture" => $picture,
           
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
    public function update(Request $request, Slider $slider)
    {
        $imageName = $slider->picture;
       
        if($request->file('picture')){
        $imageName = Carbon::now()->timestamp.'.'. $request->picture->extension();

        $request->picture->move(public_path('sliders'), $imageName);
     
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
