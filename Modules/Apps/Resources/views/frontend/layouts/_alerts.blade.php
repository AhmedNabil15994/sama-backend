@if ($errors->all())
    <div class="alert alert-danger mb-0" role="alert">
        <center>
            @foreach ($errors->all() as $error)
                <li>-<p style="display: inline-block">{{ $error }}</p></li>
            @endforeach
        </center>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-{{session('alert')}} mb-0" role="alert">
        <center>
            {!! session('status') !!}
        </center>
    </div>
@endif
