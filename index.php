<?php

use CommandString\CookieEncryption\Encryption;
use CommandString\Cookies\CookieController;
use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use React\Socket\SocketServer;
use Router\Http\Router;
use Common\Env;
use Database\Db;

require_once __DIR__ . "/vendor/autoload.php";

#  _______ __   _ _   _  _____  ______  _____  __   _ _______ _______ __   _ _______ #
# |______ | \  |  \  /    |   |_____/ |     | | \  | |  |  | |______ | \  |    |     #
# |______ |  \_|   \/   __|__ |    \_ |_____| |  \_| |  |  | |______ |  \_|    |     #

$env = Env::createFromJsonFile(__DIR__."/env.json");
$env->db = new Db();

#  ______  _____  _     _ _______ _______  ______  #
# |_____/ |     | |     |    |    |______ |_____/  #
# |    \_ |_____| |_____|    |    |______ |    \_  #

$router = new Router(new SocketServer("{$env->server->ip}:{$env->server->port}"), $env->server->dev);

#  _______  _____   _____  _     _ _____ _______ _______ #
# |       |     | |     | |____/    |   |______ |______ #
# |_____  |_____| |_____| |    \_ __|__ |______ ______| #

$env->cookie = new CookieController(new Encryption($env->cookies->encryption_passphrase, $env->cookies->encryption_algo));

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
    ->get("/", [Routes\Home::class, "main"])
    ->get("/resume", function () {
        return new HtmlResponse(Env::blade()->run("resume"));
    })

    // DO NOT ADD ROUTES BELOW THIS OR THEY WILL NOT WORK //
    ->get("/.*(".\Routes\Files\Files::generateRegex().")", [\Routes\Files\Files::class, "main"])
    ->map404("/(.*)", [\Routes\ErrorHandler::class, "handle404"])
    ->map500("/(.*)", [\Routes\ErrorHandler::class, "handle500"])
;

$router->listen();

echo "Listening on {$env->server->ip}:{$env->server->port}";
