<?php

namespace App\Http\Controllers;

use App\Repositories\NewsRepository as rNews;
use Illuminate\Http\Request;

class ParseController extends Controller
{
    private $rNews;

    public function __construct(rNews $rNews)
    {
        $this->rNews = $rNews;
    }

    public function index(rNews $parsing)
    {
        $check = $this->rNews->check();

        if(!$check){
            $parsing->parserStart();
        }
        $content = $this->rNews->getNews();

        return view('index', compact('content'));
    }
}
