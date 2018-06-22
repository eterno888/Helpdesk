<?php

namespace App\Http\Controllers;

use App\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();

        return view('news.index', ['news' => $news]);
    }

    public function create()
    {
        return view('news.create');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return back();
    }

    public function store()
    {
        News::create([
            'title'             => request('title'),
            'body'              => request('body')
        ]);

        return redirect()->route('news.index');
    }

    public function edit(News $news)
    {
        return view('news.edit', ['news' => $news]);
    }

    public function update(News $news)
    {
        $news->update([
            'title'             => request('title'),
            'body'              => request('body')
        ]);

        return redirect()->route('news.index');
    }
}