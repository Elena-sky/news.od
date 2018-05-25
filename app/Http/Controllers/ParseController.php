<?php

namespace App\Http\Controllers;

use App\Repositories\NewsRepository as rNews;
use Illuminate\Http\Request;

class ParseController extends Controller
{

    public function index(rNews $parsing)
    {
        $parsing->parserAction();

        return view('index');
    }
}
