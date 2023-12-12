<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Jobs\ImageJob;
use Illuminate\Support\Facades\Cache;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function showAllImages(){

        $page = (request()->has('page')?request()->get('page'):1);
        $keyCache = "images_page_{$page}";

        $images = Cache::get($keyCache, function () use($keyCache){
            $images = Image::with('page')->orderBy('page_id','asc')->paginate(24);
            Cache::put($keyCache, $images, now()->addMinutes(10));
            return $images;
        });


        //$images = Image::with('page')->orderBy('page_id','asc')->paginate(200);
        //$grouped = collect($images)->groupBy('page.pageName');



        return view('pages.allimages',compact('images'));
    }

    public function ShowPending(){
        $images = Image::where('path_local',null)->where('path_local_thumbnail',null)->get();
        $parseData = collect($images)->map(function($item,$key){
            //ImageJob::dispatch($item)->onQueue('images');
            //$item->put(['page'=>$item->page]);
            //$item['page'] = $item->page;
            ImageJob::dispatch($item)->onQueue('images');
            return $item;
        })->values();

        return $parseData;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Image $image)
    {
        $image->path_local = 'test1';
        $image->path_local_thumbnail = 'test2';
        $image->save();

        //$update = $image->update()
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
