<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\GoutteController;
use App\Jobs\PageJob;
class PageController extends Controller
{
    public $GoutteController;
    public $cantPaginates = 24;
    public function __construct() {
        $this->GoutteController = new GoutteController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit??$this->cantPaginates;
        $pages = Page::withCount('images')->orderBy('images_count','desc')->paginate($limit);
        $defaultCantPages = $this->cantPaginates;
        //return $pages;
        return view('pages.pages',compact('pages','limit','defaultCantPages'));
    }
    public function recorreOnJob($page){
        $request = $this->GoutteController->requestFunction($page);
    }

    public function findPending()
    {
        $data = Page::select('url')->doesntHave('images')->get()->pluck('url');
        $map = collect($data)->map(function(string $item){
            PageJob::dispatch($item)->onQueue('pages');
            return $item;
        })->values();
        return $map;
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
    public function show(Page $page)
    {
        return view('pages.images',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
