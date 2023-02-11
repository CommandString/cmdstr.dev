@extends('templates.basic')

@section('head')
    <title>Projects - Command_String</title>
    <link rel="stylesheet" href="/assets/css/projects.css">
@endsection

@section('body')
<div>
    <div id="back">
        @if ($isDev)
            <a href="/dev/projects/new"><i class="arrow big alternate circle plus icon"></i></a><br><br>
        @endif
        <a href="/"><i class="arrow big alternate circle left icon"></i></a>
    </div>
    <div class="ui inverted segment">
        @foreach ($projects as $project)
            <div class="{{ ($project["id"] % 2 === 0) ? "left" : "right" }} project">
                <div class="ui inverted massive header">
                    {!! ($project["link"]) ? "<a href='{$project["link"]}' target='_blank'>{$project["name"]}</a>" : $project["name"] !!} <span class="ui tiny text">{{ $project["start"] }} - {{ ($project["end"]) ? $project["end"] : "Present" }}</span>
                </div>
                @if ($project["thumbnail"])
                    <div class="image-div">
                        <img src="{{ $project["thumbnail"] }}" alt="Thumbnail for {{ $project["name"] }}" class="ui small image">
                    </div>
                @endif
                <span>{{ $project["description"] }}</span>
                @if ($isDev)<br>
                    <a href="/dev/projects/edit/{{ $project["id"] }}" edit><button class="ui large violet inverted button">Edit</button></a>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection