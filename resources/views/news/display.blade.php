@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('news.index') }}">{{ __('news.news') }}</a>
    </div>

    {{ Form::open(["url" => route('news.display.store')]) }}
    <input name="news_id" />
    <input name="news" />
    <button> кнопка дисплейбладе </button>
    {{ Form::close() }}
@endsection
