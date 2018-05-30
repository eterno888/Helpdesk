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
            <th> {{ __('news.created_at') }} </th>
            <th> {{ __('news.title') }}      </th>
            <th> {{ __('news.body') }}       </th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $new)
            <tr>
                <td> {{ Carbon\Carbon::parse( $new->created_at)->format("jS F Y") }} </td>
                <td> {{ $new->title }} </td>
                <td> {{ $new->body }}  </td>
                <td><a href="{{route('news.edit',$new)}}"> @icon(pencil) </a></td>
                <td><a href="{{route('news.destroy',$new)}}" class="delete-resource">@icon(trash)</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($news)
@endsection