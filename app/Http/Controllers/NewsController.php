<?php

namespace App\Http\Controllers;

use App\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = auth()->user()->admin ? News::all() : auth()->user()->news;

        return view('news.index', ['news' => $news]);
    }
}