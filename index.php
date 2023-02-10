<?php

use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use React\Socket\SocketServer;
use Router\Http\Router;
use Common\Env;
use Database\Db;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Routes\ErrorHandler;
use Routes\Projects;

require_once __DIR__ . "/vendor/autoload.php";

#  _______ __   _ _   _  _____  ______  _____  __   _ _______ _______ __   _ _______ #
# |______ | \  |  \  /    |   |_____/ |     | | \  | |  |  | |______ | \  |    |     #
# |______ |  \_|   \/   __|__ |    \_ |_____| |  \_| |  |  | |______ |  \_|    |     #

$env = Env::createFromJsonFile(__DIR__."/env.json");
$env->db = new Db(JSON_PRETTY_PRINT);


#  ______  _____  _     _ _______ _______  ______  #
# |_____/ |     | |     |    |    |______ |_____/  #
# |    \_ |_____| |_____|    |    |______ |    \_  #

$router = new Router(new SocketServer("{$env->server->ip}:{$env->server->port}"), $env->server->dev);

# ______         _______ ______  _______  _____  __   _ _______
# |_____] |      |_____| |     \ |______ |     | | \  | |______
# |_____] |_____ |     | |_____/ |______ |_____| |  \_| |______

$env->blade = new BladeOne(realpath("./views"), realpath("./compiles"), BladeOne::MODE_SLOW); // change to MODE_FAST for production
$env->blade->share("contact", [ "email" => "rsnedeker20@gmail.com", "discord" => "Command_String#6538" ]);
$env->blade->share("socials", [ "github" => "https://github.com/commandstring" ]);
#  ______  _____  _     _ _______ _______ _______ #
# |_____/ |     | |     |    |    |______ |______ #
# |    \_ |_____| |_____|    |    |______ ______| #
$router
    ->beforeMiddleware("/(.*)", function (ServerRequestInterface $req, Closure $next) use ($env) {
        $res = new Response();
        $isDev = $env->server->dev;

        $blade = Env::blade()->share("isDev", $isDev);

        if (str_starts_with($req->getRequestTarget(), "/dev") && !$isDev) {
            return ErrorHandler::handle404($req);
        }

        return $next($res, $blade, $isDev);
    })
    ->get("/", [Routes\Home::class, "main"])
    ->get("/resume", function () {
        return new HtmlResponse(Env::blade()->run("resume"));
    })
    ->get("/projects", [Projects::class, "main"])
    ->get("/dev/projects/new", [Projects::class, "getNew"])
    ->post("/dev/projects/new", [Projects::class, "postNew"])
    ->get("/dev/projects/edit/{id}", [Projects::class, "getEdit"])
    ->post("/dev/projects/edit/{id}", [Projects::class, "postEdit"])

    // DO NOT ADD ROUTES BELOW THIS OR THEY WILL NOT WORK //
    ->get("/.*(".\Routes\Files\Files::generateRegex().")", [\Routes\Files\Files::class, "main"])
    ->map404("/(.*)", [\Routes\ErrorHandler::class, "handle404"])
    ->map500("/(.*)", [\Routes\ErrorHandler::class, "handle500"])
;

$router->listen();

echo "Listening on {$env->server->ip}:{$env->server->port}";