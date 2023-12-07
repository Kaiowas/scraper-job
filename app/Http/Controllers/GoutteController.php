<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;
use Illuminate\Support\Facades\Http;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\Image;
use App\Http\Controllers\SettingController;

class GoutteController extends Controller
{
    protected $url = "https://luleamindful.com/categoria-producto/mujer/";
    protected $ignorePaths = ["/",'pase-fym-2023','lulea-kids','coleccion-no-gender','coleccion-yoga-en-la-playa','mono-crop-vaiu'];
    protected $ignorePathsComplete = [];
    protected $imageSufix = ['--640x959','-640x959'];
    protected $limit = 550;
    protected $basenameURL = "";
    protected $namePage = "";
    protected $save = false;
    protected $settings;
    public function __construct() {
        $this->settings = new SettingController;
        //$this->middleware('web');https://luleamindful.com/shop/arriba/mono-crop-vaiu/
        $this->ignorePathsComplete = $this->createPagesIfnore();
        $this->setSettings();
    }

    public function setSettings(){
        $readSettings = $this->settings->index();
        $this->url = $readSettings->url_default;
        $this->limit = $readSettings->limit;
        $this->save = $readSettings->save;
        return $readSettings;
    }
    public function testPage(){
        return ['url'=>$this->url,'limit'=>$this->limit,'save'=>$this->save];
    }

    public function createParams($url=null){
        $this->url = (isset($url)?$url:$this->url);
        $this->basenameURL = pathinfo($this->url,PATHINFO_BASENAME);
        $this->namePage = $this->createName($this->basenameURL);
    }

    public function index(Request $request){
        $this->url = (isset($request->url)?$request->url:$this->url);
        $this->limit = (isset($request->limit)?$request->limit:$this->limit);
        $this->basenameURL = pathinfo($this->url,PATHINFO_BASENAME);
        $this->namePage = $this->createName($this->basenameURL);
        $fetchContent = $this->fetchContent();
        return response()->json($fetchContent);
    }
    public function storePage($fetchContent){
        $recorre = collect($fetchContent)->map(function($item,$key){
            $newArray = ['url'=>$item['url'],'namePage'=>$item['namePage']];
            return Page::firstOrCreate($newArray);
        });

        return $recorre;

    }
    public function storeImages($fetchContent){
        $idPage = Page::select('id')->where('namePage',$fetchContent['info']['name'])->firstOrFail();

        $data = $fetchContent['data'];
        $recorre = collect($data)->map(function($item,$key) use($idPage){
            $newArray = ['page_id'=>$idPage->id,'path_external'=>$item];
            return Image::firstOrCreate($newArray);
        });

        return $recorre;

    }
    public function createName($basename){
        $parse = Str::of($basename)->trim()->title()->replace('-',' ');
        return $parse;
    }
    public function validPaths($url): bool
    {
        return !in_array($url,$this->ignorePathsComplete);
    }
    public function imageGetLarge($image){
        $original = $image;
        $replace = str_replace($this->imageSufix,"",$image);
        return ['original'=>$original,'large'=>$replace];
    }
    public function createPagesIfnore(){
        $path = "categoria-producto/mujer/page/";
        for ($i=1; $i < 10; $i++) {
            $newArray[] = $path.$i;
        }
        $result = array_merge($newArray, $this->ignorePaths);
        return $result;
    }
    public function filterFunction($data){
        $links =  $data->filter('html body div#page-container #left-area > ul.products li.product > a.woocommerce-loop-product__link');
        //$applyLink =  $url->getUri();

        $isList = $data->matches('html body.tax-product_cat');

        if($isList){
            $getContent = $links->slice(0,$this->limit)->each(function($item,$i){
                $link = $item->link();
                $uri = $link->getUri();
                $pathinfo = pathinfo($uri,PATHINFO_BASENAME);
                $namePage = $this->createName($pathinfo);
                $image = $item->filter('span.et_shop_image img')->attr('src');

                $newArray['title'] = $item->text();
                $newArray['url'] = $uri;
                $newArray['basename'] = $pathinfo;
                $newArray['namePage'] = $namePage;
                $newArray['image'] = $this->imageGetLarge($image);
                return $newArray;


            });
        } else {
            //$content =  $response->filter('html body div#page-container #left-area div.product div.slick-track > div.slick-slide');
            $images =  $data->filter('html body div#page-container img.attachment-shop_single');
            //$title = $response->filter('h1')->text();
            $getContent = $images->each(function($item){
                return $item->attr('src');
                //return $item->text();
            });
            //return $getContent;
        }


        if($isList){
            $reduce = collect($getContent)->reject(function($item,$i){
                return !$this->validPaths($item['basename']);
            })->values();
        } else {
            $reduce = $getContent;
        }
        $info = ['url'=>$this->url,'basenameURL'=>$this->basenameURL,'name'=>$this->namePage];

        $return = ['info'=>$info,'data'=>$reduce];

        if($this->save){
            if($isList){
                $storePage = $this->storePage($return['data']);
            } else {
                $storePage = $this->storeImages($return);
            }

            return $storePage;
        }

        return $return;

    }
    public function fetchContent()
    {
        /*
        $client = HttpClient::create([
            'timeout' => 900,
            'verify_peer' => false
        ]);
        $browser = new HttpBrowser($client, null);

        $crawler = $browser->request('GET', $this->url);

*/
        $filterFunction = $this->requestFunction($this->url);
        //$filterFunction = $this->filterFunction($crawler);
        //$storePage = $this->storePage($filterFunction['data']);
        return $filterFunction;
        /*
        $crawler->filter('.result__title .result__a')->each(function ($node) {
            dump($node->text());
        });
        */
    }
    public function requestFunction($url){
        $this->createParams($url);
        $client = HttpClient::create([
            'timeout' => 900,
            'verify_peer' => false
        ]);
        $browser = new HttpBrowser($client, null);

        $crawler = $browser->request('GET', $url);
        $filterFunction = $this->filterFunction($crawler);
        return $filterFunction;
    }

}
