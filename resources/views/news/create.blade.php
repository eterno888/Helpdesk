@extends('layouts.app')
@section('content')
    <div class="description">
        <a href="{{ url()->previous() }}">Новости</a>
    </div>
    <div class="comment description actions mb4">
        <h3>Создание новости</h3>
    </div>
    {{ Form::open(["url" => route('news.store')]) }}
    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr>
                <td class="w20">{{ __("news.title") }}:</td>
                <td><input name="title" class="w100" required></td>
            </tr>
            <tr>
                <td>{{ __("news.body") }}:</td>
                <td><textarea name="body" required></textarea></td>
            </tr>
            <tr>
                <td class="w20">Отображение:</td>
                <td>{{Form::checkbox('display', 1, null)}}</td>
            </tr>
            <td colspan="2">
                <button class="ph4 uppercase">@busy {{ __('news.update') }}</button>
            </td>
        </table>
        {{ Form::close() }}
    </div>
@endsection
