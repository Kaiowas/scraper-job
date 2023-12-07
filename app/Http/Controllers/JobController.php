<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spiders\LaravelDocsSpider;
use RoachPHP\Http\Response;
use RoachPHP\Roach;

class JobController extends Controller
{
    public function index()
    {
        $data  = Roach::collectSpider(LaravelDocsSpider::class);
        dd($data);
    }
}
