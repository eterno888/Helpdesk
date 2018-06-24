@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> Статистика </h3>
    </div>

    <table class="striped">
        <thead>
        <tr>
            <th> Исполнители        </th>
            <th> Количество заявок  </th>
            <th> Средняя оценка     </th>
        </tr>
        </thead>
            @foreach($users as $user)
                @if (App\Ticket::where('user_id', $user->id)->count() > 0)
            <tr>
                <td> {{ $user->name }}                                      </td>
                <td> {{ App\Ticket::where('user_id', $user->id)->count()}}  </td>
                <td> {{ number_format(App\Rating::ratingToUser($user), 2)}} </td>
            </tr>
            @endif
        @endforeach
    </table>

@endsection