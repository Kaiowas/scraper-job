<?php
namespace App\Traits;

use AshAllenDesign\ShortURL\Classes\Builder;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait ShortUrlTrait
{

    public function __construct()
    {

    }

    public function getAll()
    {
        $data = ShortURL::with('visits')->get();
        //$data->trackingEnabled();
        return $data;
    }
    public function createShortUrl(string $url=null,string $key=null){

        if(!isset($url)){
            return false;
        }

        $builder = (new Builder());
        $shortURLObject = $builder->destinationUrl($url);

        if(isset($key)){
            $shortURLObject = $shortURLObject->urlKey($key);
        }

        $shortURLObject = $shortURLObject->make();

        $shortURL = $shortURLObject->default_short_url;

        return $shortURL;
    }
    public function getUrlByKey(string $key)
    {
        $shortURL = ShortURL::findByKey($key);
        return $shortURL;
    }

    public function getUrlByDestination(string $url)
    {
        $shortURL = ShortURL::findByDestinationURL($url);
        return $shortURL;
    }
}
