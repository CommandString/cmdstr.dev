<?php

namespace Routes;

use Common\Env;
use HttpSoft\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Home {
    public static function main(RequestInterface $req, ResponseInterface $res): ResponseInterface
    {
        return new HtmlResponse(Env::blade()->run("home"));
    }
}