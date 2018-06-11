<?php

namespace App\Http\Controllers;

use App\News;

class NewsDisplayController extends Controller
{
    public function index()
    {
        return view('news.display');
    }

    public function store()
    {
        News::findOrFail(request('news_id'))->display(request('news'));

        return redirect()->route('news.index');
    }
}
