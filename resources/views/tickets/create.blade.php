@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
    </div>

    {{ Form::open(["url" => route("tickets.store")]) }}
    <div class="comment description actions">
        <table class="maxw600 no-padding">
            <tr>
                <td class="w20"><b> {{ __('ticket.requester') }}:</b></td>
            </tr>
            <tr>
                <td>{{ __('user.name')  }}:</td>
                <td class="w100"><input type="name" name="name" value="{{$user->name}}" class="w100" required></td>
            </tr>
            <tr>
                <td>{{ __('user.email') }}:</td>
                <td class="w100"><input type="email" name="email" value="{{$user->email}}" class="w100" required></td>
            </tr>
            <tr>
                <td>{{ __('user.cabinet') }}:</td>
                <td class="w100"><input type="text" name="cabinet" value="{{$user->cabinet}}" class="w100" required>
                </td>
            </tr>
            <tr>
                <td>{{ __('user.phone') }}:</td>
                <td class="w100"><input type="text" name="phone" value="{{$user->phone}}" class="w100" required></td>
            </tr>
            <tr>
                <td>{{ __('user.position') }}:</td>
                <td class="w100"><input type="text" name="position" value="{{$user->position}}" class="w100" required>
                </td>
            </tr>
            <tr>
                <td>{{ __('user.subdivision') }}:</td>
                <td class="w100"><input type="text" name="subdivision" value="{{$user->subdivision}}" class="w100"
                                        required></td>
            </tr>
            <tr>
                <td>{{ __('user.lead') }}:</td>
                <td class="w100"><input type="text" name="lead" value="{{$user->lead}}" class="w100" required></td>
            </tr>
        </table>
    </div>

    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr>
                <td class="w20">Тема:</td>
                <td><input name="title" class="w100" value="{{$ticketType->name}}" required/></td>
            </tr>
            @include('components.ticket.ticketType')
            <tr>
                <td>{{ __('ticket.status') }}:</td>
                <td >
                    {{ Form::select("status", [
                        App\Ticket::STATUS_NEW      => __("ticket.new"),
                        App\Ticket::STATUS_OPEN     => __("ticket.open"),
                        App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                    ]) }}
                    <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.send') }}</button>
                </td>

            </tr>
        </table>
    </div>
    {{ Form::close() }}
@endsection

