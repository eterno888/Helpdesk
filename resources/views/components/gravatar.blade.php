@gravatar( $user->email )
@if($user instanceof App\User && $user->admin )
    <div class="inline ml-3 gold">@icon(star)</div>
@endif