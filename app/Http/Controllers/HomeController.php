<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function runPagesJob(){
        $exitCode = Artisan::call('queue:work --queue=pages --stop-when-empty');
        return response()->json($exitCode);
    }

    public function runImagesJob(){
        $exitCode = Artisan::call('queue:work --queue=images --stop-when-empty');
        return response()->json($exitCode);
    }

    public function routes(){
        $url_default = Setting::firstOrFail()->select('url_default')->get()->pluck('url_default')->first();
        $routes = array(
            array(
                'title' => 'Get and Set Pages',
                'description' => "Busca y guarda paginas. Si no se especifica, recurre a la configurada. {$url_default}",
                'endpoint' => route('goutte.index'),
                'method' => 'post',
                'params' => ['url','limit'],
            ),
            array(
                'title' => 'Get and Set images from pages',
                'description' => 'Recorre las paginas, crea los registros y se encola para crear imagenes y captura',
                'endpoint' => route('page.findPending'),
                'method' => 'get',
                'params' => [],
            ),
            array(
                'title' => 'Get images pending',
                'description' => 'Recorre las imagenes faltantes para crear',
                'endpoint' => route('image.ShowPending'),
                'method' => 'get',
                'params' => [],
            ),
        );

        return view('pages.routes',compact('routes'));
    }
}
/*

Busca y guarda paginas
http://scraper-jobs.dev.com/api/goutte/index
POST: url/limit

Recorre las paginas, crea los registros y se encola para crear imagenes y captura
http://scraper-jobs.dev.com/page/findPending

Recorre las imagenes faltantes para crear
http://scraper-jobs.dev.com/image/ShowPending
*/
