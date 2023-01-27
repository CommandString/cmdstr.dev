<?php

use CommandString\CookieEncryption\Encryption;
use CommandString\Cookies\CookieController;
use CommandString\Pdo\Driver;
use eftec\bladeone\BladeOne;
use React\Socket\SocketServer;
use Router\Http\Router;
use Common\Env;

require_once __DIR__ . "/vendor/autoload.php";

#  _______ __   _ _   _  _____  ______  _____  __   _ _______ _______ __   _ _______ #
# |______ | \  |  \  /    |   |_____/ |     | | \  | |  |  | |______ | \  |    |     #
# |______ |  \_|   \/   __|__ |    \_ |_____| |  \_| |  |  | |______ |  \_|    |     #

if (!file_exists(__DIR__."/env.json")) {
    file_put_contents(__DIR__."/env.json", file_get_contents(__DIR__."/env.example.json"));
    echo "Environment configuration does not exist, creating env.json!\n";
}

$env = Env::createFromJsonFile(__DIR__."/env.json");

#  ______  _____  _     _ _______ _______  ______  #
# |_____/ |     | |     |    |    |______ |_____/  #
# |    \_ |_____| |_____|    |    |______ |    \_  #

$router = new Router(new SocketServer("{$env->server->ip}:{$env->server->port}"), $env->server->dev);

#  ______  _______ _______ _______ ______  _______ _______ _______ #
# |     \ |_____|    |    |_____| |_____] |_____| |______ |______ #
# |_____/ |     |    |    |     | |_____] |     | ______| |______ #

if ($env->database->enabled) {
    $env->driver = Driver::createMySqlDriver($env->database->username, $env->database->password, $env->database->name, $env->database->host, $env->database->port)->connect();
}

#  _______  _____   _____  _     _ _____ _______ _______ #
# |       |     | |     | |____/    |   |______ |______ #
# |_____  |_____| |_____| |    \_ __|__ |______ ______| #

if ($env->cookies->enabled) {
    $env->cookie = new CookieController(new Encryption($env->cookies->encryption_passphrase, $env->cookies->encryption_algo));
}

# ______         _______ ______  _______  _____  __   _ _______
# |_____] |      |_____| |     \ |______ |     | | \  | |______
# |_____] |_____ |     | |_____/ |______ |_____| |  \_| |______

$env->blade = new BladeOne(realpath("./views"), realpath("./compiles"), BladeOne::MODE_SLOW); // change to MODE_FAST for production

#  ______  _____  _     _ _______ _______ _______ #
# |_____/ |     | |     |    |    |______ |______ #
# |    \_ |_____| |_____|    |    |______ ______| #
$router
    ->get("/", [Routes\Home::class, "main"])

    // DO NOT ADD ROUTES BELOW THIS OR THEY WILL NOT WORK //
    ->get("/.*(".\Routes\Files\Files::generateRegex().")", [\Routes\Files\Files::class, "main"])
    ->map404("/(.*)", [\Routes\ErrorHandler::class, "handle404"])
    ->map500("/(.*)", [\Routes\ErrorHandler::class, "handle500"])
;

$router->listen();

echo "Listening on {$env->server->ip}:{$env->server->port}";
