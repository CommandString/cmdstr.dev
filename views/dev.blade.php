@extends('templates.basic')

@section('head')
    <title>Projects - Command_String</title>
    <link rel="stylesheet" href="/assets/css/dev.css">
@endsection

@section('body')
<div>
    <div id="back">
        <a href="/"><i class="arrow big alternate circle left icon"></i></a>
    </div>
    <div class="login">
        <form method="POST" class="ui inverted big form">
            <div class="field">
                <label>Developer Login</label>
                <input type="password" name="password" placeholder="Developer Password">
            </div>
            <div class="field">
                <button class="ui button big fluid violet">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection