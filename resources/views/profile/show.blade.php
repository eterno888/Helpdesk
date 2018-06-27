@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> {{ __('user.profile') }}</h3>
    </div>

    <div class="description actions comment mb4">
        <div class="float-left ml4  shadow-outer-1 circle">@gravatar($user->email, 90)</div>
        <h3 class="ml4 float-left"> @if($user->admin) <span class="gold">@icon(star)</span> @endif {{ $user->name }}</h3>
        <div class="clear-both mb-5"> </div>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4 new-comment">
        {{ Form::open( ["url" => route('profile.update'), 'method' => 'PUT'] ) }}
            <table class="maxw600">
            <tr><td> {{ __('user.name')     }}:    </td><td class="w60">{{ Form::text('name',                     $user->name,         ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.email')    }}:    </td><td class="w60">{{ Form::email('email',                   $user->email,        ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.cabinet')  }}:    </td><td class="w60">{{ Form::text('cabinet',                  $user->cabinet,      ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.phone')    }}:    </td><td class="w60">{{ Form::text('phone',                    $user->phone,        ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.position') }}:    </td><td class="w60">{{ Form::text('position',                 $user->position,     ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.subdivision') }}: </td><td class="w60">{{ Form::text('subdivision',              $user->subdivision,  ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.lead')     }}:    </td><td class="w60">{{ Form::text('lead',                     $user->lead,         ["class" => "w100"]) }}</td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>

@endsection