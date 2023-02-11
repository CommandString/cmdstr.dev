@extends('templates.basic')

@section('head')
    <title>New Project - Command_String</title>
    <link rel="stylesheet" href="/assets/css/newProject.css">
@endsection

@section('body')
    <div>
        <div id="back">
            <a href="/projects"><i class="arrow big alternate circle left icon"></i></a>
        </div>
        <form method="POST" enctype="multipart/form-data" class="ui inverted form">
            <div class="three fields">
                <div class="field">
                    <span class="ui large text">Project Name</span>
                    <input type="text" value="{{ $post['name'] ?? ""}}" placeholder="Project Name" name="name">
                </div>
                <div class="field">
                    <span class="ui large text">Link</span>
                    <input type="text" value="{{ $post['link'] ?? ""}}" placeholder="Link" name="link">
                </div>
                <div class="field">
                    <span class="ui large text">Thumbnail Link</span>
                    <input type="text" value="{{ $post['thumbnail'] ?? ""}}" placeholder="Thumbnail Link" name="thumbnail">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <span class="ui large text">Start Date</span>
                    <div class="ui inverted calendar" id="start-date">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" value="{{ $post['start'] ?? ""}}" name="start" placeholder="Start">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <span class="ui large text">End Date</span>
                    <div class="ui inverted calendar" id="end-date">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" @if ($post["end"] ?? false) value="{{ $post['end'] }}" @endif name="end" placeholder="End">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <span class="ui large text">Description</span>
                <textarea name="description" rows="4">{{ $post['description'] ?? ""}}</textarea>
            </div>
            
            @if (isset($edit))
                <button class="ui large yellow fluid button">Edit</button>
            @else
                <button class="ui large green fluid button">Create</button>
            @endif
        </form>
    </div>

    <script>
        $('#start-date').calendar({
            type: 'date',
            endCalendar: $('#end-date')
        });
        $('#end-date').calendar({
            type: 'date',
            startCalendar: $('#start-date')
        });

        $("#thumbnail").on("click", function () {
            $("[name='thumbnail']").click()
        });

        @if (!empty($errors ?? []))
        @foreach ($errors as $error)
            $.toast({
                "title": "{{ $error }}",
                "class": "red"
            });
        @endforeach
        @endif
    </script>
@endsection
