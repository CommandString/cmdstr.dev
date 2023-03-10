@extends('templates.basic')

@section('head')
    <title>Resume - Command_String</title>
    <link rel="stylesheet" href="/assets/css/resume.css">
@endsection

@section('body')
<div>
    <div id="back">
        <a href="/"><i class="arrow big alternate circle left icon"></i></a>
    </div>
    <div class="ui inverted segment">
        <div class="ui stackable grid">
            <div class="row">
                <div class="sixteen wide column">
                    <h1 id="name" class="ui left floated inverted header">
                        <img src="/assets/img/me.png" class="ui bottom aligned image">
                        <span>R. Michael Snedeker</span>
                    </h1>
                    <h1 id="contact" class="ui inverted right floated header">
                        <span><a href="mailto:{{ $contact["email"] }}"><i class="envelope icon"></i> {{ $contact["email"] }}</a></span> <br>
                        <span><a target="_blank" href="{{ $socials["github"] }}"><i class="github icon"></i> CommandString</a></span><br>
                        <span><a href="https://cmdstr.dev" class="href"><i class="globe icon"></i> cmdstr.dev</a></span>
                    </h1>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="row">
                <div class="four wide column">
                    <h1 class="ui massive inverted header">Career Objective</h1>
                </div>
                <div class="twelve wide column">
                    <span class="ui large text">Competent self-driven PHP developer who is looking to connect with a professional organization to grow within the web design and development field. Additional skillsets include the ability to effectively communicate, work within teams to meet common deadlines and goals, as well as an understanding of computer design and repair.</span>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="row">
                <div class="four wide column">
                    <h1 class="ui massive inverted header">Education</h1>
                </div>
                <div class="twelve wide column">
                    <span class="ui big text"><b>Dallastown Senior High School</b></span><br>
                    <span class="ui large text">Dallastown, PA</span>
                    <ul>
                        <li>Anticapated Graduation: June 2023</li>
                        <li>Relevant Courses: Computer Programming I, Website Development, Honors Robotics, Honors Electronics</li>
                    </ul>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="row">
                <div class="four wide column">
                    <h1 class="ui massive inverted header">Work History</h1>
                </div>
                <div class="twelve wide column">
                    <span class="ui big text"><b>Teacher Assistant <span class="ui small text">(11/2022 - Present)</span></b></span><br>
                    <span class="ui large text">Dallastown, PA</span>
                    <ul>
                        <li>Assisted students in Web Development course with design, coding and other questions/concerns.</li>
                        <li>Supplemented lesson materials and ideas at teacher's discretion and direction.</li>
                    </ul>
                    <span class="ui big text"><b>R&M Computer Diagnostics <span class="ui small text">(3/2014 - 1/2017)</span></b></span><br>
                    <span class="ui large text">Hanover, PA</span>
                    <ul>
                        <li>Developed initial understanding of how computers work and are built.</li>
                        <li>Assisted in development and installation of CCTV projects.</li>
                        <li>Worked with customers to restore computers laptops.</li>
                        <li>Diagnosed and repaired network complications.</li>
                    </ul>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="row">
                <div class="four wide column">
                    <h1 class="ui massive inverted header">Relevant Skillsets</h1>
                </div>
                <div id="skillsets" class="twelve wide column">
                    <div class="ui equal width stackable grid">
                        <div class="column">
                            <div class="ui massive header inverted">Coding</div>
                            <ul>
                                <li>PHP</li>
                                <li>JavaScript</li>
                                <li>TypeScript</li>
                                <li>HTML</li>
                                <li>CSS</li>
                                <li>SCSS</li>
                                <li>MySQL</li>
                                <li>Batch</li>
                            </ul>
                        </div>
                        <div class="column">
                            <div class="ui massive header inverted">Frameworks/Libraries</div>
                            <ul>
                                <li>DiscordPHP</li>
                                <li>jQuery</li>
                                <li>Fomantic-UI</li>
                                <li>Twig</li>
                                <li>ReactPHP</li>
                                <li>BladeOne/Blade</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="row">
                <div class="four wide column">
                    <h1 class="ui massive inverted header">Achievements</h1>
                </div>
                <div class="twelve wide column">
                    <span class="ui big text"><b>Future Business Leaders of America</b> <span class="ui small text">(FBLA)</span></span><br>
                    <ul>
                        <li>Website Development State Finalist 2023</li>
                    </ul>
                    <span class="ui big text"><b>Dallastown Big Buddy</b></span><br>
                    <ul>
                        <li>High Schoolers are assigned students in the elementary schools to keep in contact with and to also serve as role models.</li>
                    </ul>
                    <span class="ui big text"><b><a href="https://github.com/discord-php/DiscordPHP" target="_blank">DiscordPHP</a> Collaborator</b></span><br>
                    <ul>
                        <li>DiscordPHP is a bot API wrapper written in PHP.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection