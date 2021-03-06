@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> {{ trans_choice('team.team', 2) }} ( {{ $teams->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("teams.create") }}">@icon(plus) {{ __('team.new') }}</a>
    </div>

    @paginator($teams)
    <table class="striped">
        <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('team.team',1) }}          </th>
            <th> {{ trans_choice('team.email',1) }}         </th>
            <th> {{ trans_choice('team.member',2) }}        </th>
            <th> {{ __('team.phone') }}                     </th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td class="small"> @gravatar($team->email)</td>
                <td> {{ $team->name }}</td>
                <td><a href="mailto:{{ $team->email }}">{{ $team->email }}</a></td>
                <td><a href="{{route('teams.agents',$team)}}">{{ $team->members->count() }}</a></td>
                <td> {{ $team->phone }}</td>

                <th><a href="{{route('tickets.index')}}?team={{$team->id}}"> @icon(inbox) </a></th>
                @can('administrate', $team)
                    <th><a href="{{route('teams.edit',$team)}}"> @icon(pencil) </a></th>
                    <th><a href="{{route('teams.destroy',$team)}}" class="delete-resource">@icon(trash)</a></th>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($teams)
@endsection
