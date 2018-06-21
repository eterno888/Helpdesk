@extends('layouts.app')
@section('content')
    <div class="description">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">Новости</a>
        </div>
    </div>

    <div class="description actions comment mb4">
        <h3 class="ml4"> {{ $news->title }}</h3>
    </div>

    <div class="clear-both"></div>


    <div class="comment new-comment">
        {{ Form::open(["url" => route('news.update', $news), "method" => "PUT"]) }}
        <table class="maxw600 no-padding">
            <tr>
                <td class="w20">{{ __("news.title") }}:</td>
                <td><input class="w100" name="title" value="{{$news->title}}"></td>
            </tr>
            <tr>
                <td class="w20">{{ __("news.body") }}:</td>
                <td class="w100"><textarea name="body" class="r10">{{$news->body}}</textarea></td>
            </tr>
            <tr>
                <td class="w20">Отображение:</td>
                <td>{{Form::checkbox('display', 1, $news->display)}}</td>
            </tr>
            <td colspan="2">
                <button class="ph4 uppercase">@busy {{ __('news.update') }}</button>
            </td>
        </table>
        {{ Form::close() }}
    </div>
@endsection