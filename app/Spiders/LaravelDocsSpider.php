<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class LaravelDocsSpider extends BasicSpider
{
    public array $startUrls = [
        'https://luleamindful.com/categoria-producto/mujer/'
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $links =  $response->filter('html body div#page-container #left-area > ul.products li.product > a.woocommerce-loop-product__link');
        //$applyLink =  $url->getUri();

        $getContent = $links->slice(0,2)->each(function($item,$i){
            $link = $item->link();
            $newArray['title'] = $item->text();
            $newArray['url'] = $link->getUri();
            $newArray['image'] = $item->filter('span.et_shop_image img')->attr('src');
            //$newArray['page'] = $this->request('GET', $link->getUri(),'parseDetailPage');
            return $newArray;
        });

        yield $this->item(compact('getContent'));

/*
        foreach ($getContent as $key => $value) {
            $getUri = $value['url'];
            //$getContent[$key]['page'] = $this->request('GET', $getUri,'parseDetailPage');
            yield $this->request('GET', $getUri,'parseDetailPage');
        }
*/
    }

    public function parseDetailPage(Response $response): Generator
    {
        //$content =  $response->filter('html body div#page-container #left-area div.product div.slick-track > div.slick-slide');
        $content =  $response->filter('html body div#page-container img.attachment-shop_single');
        //$title = $response->filter('h1')->text();
        $images = $content->each(function($item){
            return $item->attr('src');
            //return $item->text();
        });

        //$images = $content->extract(['_text', 'href']);
        yield $this->item(compact('images'));
    }

}
