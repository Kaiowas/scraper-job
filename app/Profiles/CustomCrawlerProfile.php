<?php

namespace App\Profiles;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;

class CustomCrawlerProfile extends CrawlProfile
{
    protected mixed $baseUrl;
    protected $ignorePaths = ["/",'/fym-2023/','/lulea-kids/','/coleccion-no-gender/','/coleccion-yoga-en-la-playa/'];
    protected $ignorePathsComplete = [];

    public function __construct($baseUrl)
    {
        if (! $baseUrl instanceof UriInterface) {
            $baseUrl = new Uri($baseUrl);
        }

        $this->baseUrl = $baseUrl;
        $this->ignorePathsComplete = $this->createPagesIfnore();
    }

    public function shouldCrawl(UriInterface $url): bool
    {
        return ($this->baseUrl->getHost() === $url->getHost()) && $this->validPaths($url->getPath());
    }

    public function validPaths($url): bool
    {
        return !in_array($url,$this->ignorePathsComplete);
    }

    public function createPagesIfnore(){
        $path = "/categoria-producto/mujer/page/";
        for ($i=1; $i < 10; $i++) {
            $newArray[] = $path.$i."/";
        }
        $result = array_merge($newArray, $this->ignorePaths);
        return $result;
    }
}
