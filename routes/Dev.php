<?php

namespace Routes;

use Common\Env;
use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use HttpSoft\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dev {
    public static function get(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade, bool $isDev): ResponseInterface 
    {
        if ($isDev) {
            return new RedirectResponse("/");
        }

        return new HtmlResponse($blade->run("dev"));
    }

    public static function post(ServerRequestInterface $req, ResponseInterface $res): ResponseInterface
    {
        $post = $req->getParsedBody();
        $res = new RedirectResponse("/");

        if (password_verify($post["password"] ?? "", Env::get()->server->devPasswordHash)) {
            $cookie = Env::get()->cookie->cookie($req, $res);
            $cookie->set("dev",  Env::get()->server->devSessionToken);
        }

        return $res;
    }
}