@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('news.news', 2) }}</h3>
    </div>

    <div class="description">
        {{ Form::open( ["url" => route('news.index'), 'method' => 'GET'] ) }}
        @include('components.datesFilter')
        {{ Form::close() }}
    </div>

    <table class="striped">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
    </table>

@endsection