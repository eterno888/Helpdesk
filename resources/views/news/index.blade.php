@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ __('news.news') }} ( {{ $news->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button" href="{{ route("news.create") }}" >@icon(plus) {{ __('news.new') }}</a>
    </div>

    @paginator($news)
    <table class="striped">
        <thead>
        <tr>
            <th></th>
            <th> {{ __('news.created_at') }} </th>
            <th> {{ __('news.title') }}      </th>
            <th> {{ __('news.body') }}       </th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $news)
            <tr>
                <td> <input type="checkbox" name="selected[{{$news->id}}]" meta:index="{{$news->id}}" class="hidden selector"></td>
                <td> {{ Carbon\Carbon::parse( $news->created_at)->format("jS F Y") }} </td>
                <td> {{ $news->title }} </td>
                <td> {{ $news->body }}  </td>
                <td><a href="{{route('news.edit',$news)}}"> @icon(pencil) </a></td>
                <td><a href="{{route('news.destroy',$news)}}" class="delete-resource">@icon(trash)</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($news)
@endsection