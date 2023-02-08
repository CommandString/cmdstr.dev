@extends('templates.basic')

@section('head')
    <title>Command_String</title>
    <link rel="stylesheet" href="/assets/css/home.css">

    <meta property="og:title" content="Command_String" />
    <meta property="og:url" content="https://cmdstr.dev" />
    <meta property="og:image" content="https://cmdstr.dev/assets/img/logo.png" />
    <meta property="og:description" content="I'm Michael, or as most people call me, Command_String.">
@endsection

@section('body')
    <div>
        <div id="nametag">
            <img class="ui image" src="/assets/img/logo.png">
            <div>
                <p>Command_String</p>
                <p>Michael Snedeker</p>
            </div>
        </div>
        <div id="iam">
            <span>I am</span>
        </div>
        <div id="contact">
            <div>
                <span><i class="envelope icon"></i> {{ $contact["email"] }}</span>
            </div>
            <div>
                <img src="https://lanyard.cnrad.dev/api/232224992908017664" alt="Discord Status">
                <span>{{ $contact["discord"] }} <i class="discord icon"></i></span>
            </div>
            <div>
                <span><i class="envelope icon"></i> {{ $contact["email"] }}</span>
                <br>
                <span> <i class="discord icon"></i> {{ $contact["discord"] }}</span>
            </div>
        </div>
        <div id="buttons" class="ui equal width stackable grid">
            <div class="row">
                @php
                    $buttonCount = 0;
                @endphp
                @foreach ($buttons as $name => $href)
                    @php
                        $buttonCount++;
                    @endphp
                    @if ($buttonCount === 4 || $buttonCount === 7)
                        </div><div class="row">
                    @endif
                    <a href="{{ $href }}" @if (!str_starts_with($href, "/")) target="_blank" @endif class="column">
                        <div class="ui inverted horizontal divider">
                            {{ $name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection