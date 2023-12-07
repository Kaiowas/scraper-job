<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\CustomCrawlerObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use App\Profiles\CustomCrawlerProfile;
use Spatie\Crawler\Crawler;
use App\Http\Controllers\Controller;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;
use Spatie\Browsershot\Browsershot;

class CustomCrawlerController extends Controller {

    protected $url = "https://luleamindful.com/categoria-producto/mujer/";
    public function __construct() {

    }

    public function setUrl(Request $request){
        $this->url = (isset($request->url)?$request->url:$this->url);
        $this->fetchContent();
    }

    /**
     * Crawl the website content.
     * @return true
     */
    public function fetchContent(){
        //$browsershot = new Browsershot;
        //# initiate crawler
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => true, RequestOptions::TIMEOUT => 30])
        //->setBrowsershot($browsershot)
        ->acceptNofollowLinks()
        ->ignoreRobots()
        // ->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new CustomCrawlerObserver())
        //->setCrawlProfile(new CrawlInternalUrls($this->url))
        ->setCrawlProfile(new CustomCrawlerProfile($this->url))
        ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
        ->setTotalCrawlLimit(50) // limit defines the maximal count of URLs to crawl
        // ->setConcurrency(1) // all urls will be crawled one by one
        ->setDelayBetweenRequests(100)

        //->executeJavaScript()
        ->startCrawling($this->url);
        return true;
    }
}


