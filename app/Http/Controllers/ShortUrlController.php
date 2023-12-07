<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ShortUrlTrait;
class ShortUrlController extends Controller
{
    use ShortUrlTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->getAll();
        return view('pages.shortUrls',compact('data'));
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
        $data = $request->only('url', 'key');

        $createShortUrl = $this->createShortUrl($data['url'],$data['key']);

        $status = true;
        $sessionMsg = "Se guardo correctamente. {$createShortUrl}";

        $sesionArray = ['status' => ($status ? 'success' : 'danger'), 'msg' => $sessionMsg];

        return redirect()->back()->with('message', $sesionArray);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
