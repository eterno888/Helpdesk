@foreach($news as $news)
    @if($news->display === 1)

    <div class="mb0 mt5 p4 bg-danger white br1" style=" opacity: 0.8; background-color:#46A5E0;">
        {{ $news->body }}
    </div>
    @endif
@endforeach

