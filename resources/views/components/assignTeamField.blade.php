@php if (! isset($team)) $team = new App\Team; @endphp
<tr>
    <td>{{ trans_choice('team.team',1) }}:</td>
        <td>{{ Form::select('team_id', createSelectArray( App\Team::all(), true), $team->id) }}
</td>