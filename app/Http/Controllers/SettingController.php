<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSettingRequest;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Setting::firstOrFail();
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
    public function show()
    {
        $settings = Setting::firstOrFail();
        return view('pages.settings',compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //$valores = $request->all();https://luleamindful.com/categoria-producto/mujer/

        $request->mergeIfMissing(['save' => 0]);

        $validated = $request->validate([
            'url_default' => ['required', 'string', 'min:1', 'max:255'],
            'limit' => ['required', 'integer', 'min:-2147483648', 'max:2147483647'],
            'save' => ['required', 'boolean']
        ]);

        $setting->save = ($request->save?1:0);
        $setting->url_default = $request->url_default;
        $setting->limit = (int)$request->limit;


        $setting->update();

        $status = true;
        $sessionMsg = "Se guardo correctamente";

        $sesionArray = ['status' => ($status ? 'success' : 'danger'), 'msg' => $sessionMsg];

        return redirect()->back()->with('message', $sesionArray);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
