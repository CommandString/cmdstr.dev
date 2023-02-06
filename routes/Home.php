<?php

namespace Routes;

use Common\Env;
use HttpSoft\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Home {
    public static function main(RequestInterface $req, ResponseInterface $res): ResponseInterface
    {
        $buttons = [
            "Projects" => "/projects",
            "Discord Server" => "https://discord.gg/TgrcSkuDtQ",
            "Resume" => "/resume",
            // "Packagist" => "https://packagist.org/users/command_string/",
            "Github" => "https://github.com/commandstring",
            "View Source" => "https://github.com/commandstring/cmdstr.dev",
            // "CmdMicro" => "https://github.com/commandstring/cmdmicro",
            // "DiscordPHP Bot Template" => "https://github.com/commandstring/discordphp-bot-template"
        ];

        return new HtmlResponse(Env::blade()->run("home", ["buttons" => $buttons]));
    }
}