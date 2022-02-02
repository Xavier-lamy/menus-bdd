{{--Alerts--}}
@if(session('error') !== null)
    <div class="alert--warning my--2 p--2">
        {{ session('error') }}
    </div>
@elseif(session('success') !== null)
    <div class="alert--success my--2 p--2">
        {{ session('success') }}
    </div>
@elseif(session('message') !== null)
    <div class="alert--message my--2 p--2">
        {{ session('message') }}
    </div>
@elseif($errors->any())
    <ul class="alert--warning my--2 p--2 list--unstyled">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
{{--End alerts--}}