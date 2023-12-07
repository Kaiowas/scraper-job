<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Crawler\Crawler;
use App\Observers\CustomCrawlerObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class CrawlerController extends Controller
{
    protected $url = "https://luleamindful.com/categoria-producto/mujer/";
    public function index(){



        $data = Crawler::create()
        ->setCrawlProfile(new CrawlInternalUrls($this->url))
        ->setTotalCrawlLimit(10)
        //->setCurrentCrawlLimit(5)
        ->startCrawling($this->url);


    }
}
