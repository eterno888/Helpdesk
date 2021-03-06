@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Сотрудники ( {{ $users->count() }} )</h3>
    </div>

    <div class="m4">
        <input id="searcher" placeholder="{{__('ticket.search')}}" class="ml2">
        <div class="inline ml-4">@icon(search)</div>
    </div>

    @paginator($users)
    <table class="striped">
        <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('team.name',1) }}      </th>
            <th> {{ trans_choice('team.email',2) }}     </th>
            <th> {{ trans_choice('team.team',2) }}      </th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td> @include("components.gravatar",["user" => $user]) </td>
                <td> {{ $user->name }}</td>
                <td> {{ $user->email }}</td>
                <td> {{ implode(", ", $user->teams->pluck('name')->toArray() ) }}</td>
                <td> <a href="{{ route('users.edit', $user) }}"> @icon(pencil) </a></td>
                <td> <a href="{{ route('users.impersonate', $user) }}"> @icon(key) </a></td>
                <td> <a href="{{ route('users.destroy', $user) }}" class="delete-resource"> @icon(trash)</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($users)
@endsection

@section('scripts')
    <script>
        $("#searcher").searcher('tickets/search/');
    </script>
@endsection