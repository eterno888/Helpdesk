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

    /* function debug_to_console( $data ) {
         $output = $data;
         if ( is_array( $output ) )
             $output = implode( ',', $output);

         echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
     }*/

    public function store()
    {
        News::create([
            'title' => request('title'),
            'body' => request('body'),
            'display' => request('display')
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
            'title' => request('title'),
            'body' => request('body'),
            'display' => request('display')
        ]);

        return redirect()->route('news.index');
    }
}