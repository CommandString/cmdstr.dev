<?php

namespace Routes;

use Common\Env;
use HttpSoft\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ServerRequest;

class ErrorHandler {
    public static function handle404(ServerRequest $req): ResponseInterface
    {
        return new HtmlResponse(Env::blade()->run("errors.404", ["uri" => $req->getRequestTarget()]));
    }

    public static function handle500(ServerRequest $req): ResponseInterface
    {
        return new HtmlResponse(Env::blade()->run("errors.500", ["uri" => $req->getRequestTarget()]));
    }
}