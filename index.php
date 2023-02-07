<?php

use Carbon\Carbon;
use CommandString\JsonDb\Exceptions\InvalidValue;
use CommandString\JsonDb\Exceptions\UniqueRowViolation;
use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use HttpSoft\Response\RedirectResponse;
use React\Socket\SocketServer;
use Router\Http\Router;
use Common\Env;
use Database\Db;
use Database\Projects\Projects;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Routes\ErrorHandler;

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
        $cookie = $env->cookie->cookie($req, $res);
        $isDev = in_array($req->getServerParams()["REMOTE_ADDR"] ?? "", (array) $env->server->dev_ips);

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
    ->get("/projects", function (ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) use ($env) {
        $projects = $env->db->projects;
        $rows = $projects->newQuery()->execute();
        $dateFormat = "n/j/Y";

        foreach (array_keys($rows) as $key) {
            $row = & $rows[$key];
            $row = $row->jsonSerialize();

            $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

            if ($row["end"]) {
                $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
            }
        }

        return new HtmlResponse($blade->run("projects", ["projects" => $rows]));
    })
    ->get("/dev/projects/new", function (ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) {
        return new HtmlResponse($blade->run("newProject"));
    })
    ->post("/dev/projects/new", function (ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) use ($env) {
        $post = $req->getParsedBody();

        $required = ["name", "start", "description"];
        $optional = ["end", "link", "thumbnail"];

        try {
            $row = $env->db->projects->newRow();

            foreach ($required as $key) {
                $value = $post[$key] ?? "";

                if (empty($value)) {
                    throw new InvalidArgumentException;
                }

                $row->setColumn($key, ($key === Projects::START) ? (new Carbon($value))->getTimestamp() : $value);
            }

            foreach ($optional as $key) {
                $value = $post[$key] ?? "";

                if (!empty($value)) {
                    $row->setColumn($key, ($key === Projects::END) ? (new Carbon($value))->getTimestamp() : $value);
                }
            }

            $row->store();
        } catch (InvalidArgumentException|InvalidValue|UniqueRowViolation $e) {
            $dateFormat = "F n, Y";
            $post->start = (new Carbon($post->start))->format($dateFormat);

            if ($post->end) {
                $post->end = (new Carbon($post->start))->format($dateFormat);
            }

            return new HtmlResponse($blade->run("newProject", ["post" => $post]));
        }

        return new RedirectResponse("/projects");
    })
    ->get("/dev/projects/edit/{id}", function (ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) use ($env) {
        $row = $env->db->projects->getRows()[$id] ?? null;

        if (is_null($row)) {
            return new RedirectResponse("/projects");
        }

        $row = $row->jsonSerialize();
        
        $dateFormat = "F j, Y";
        $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

        echo $row["start"];

        if ($row["end"]) {
            $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
        }
        
        return new HtmlResponse($blade->run("newProject", ["post" => $row, "edit" => true]));
    })
    ->post("/dev/projects/edit/{id}", function (ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) use ($env) {
        $post = $req->getParsedBody();

        $required = ["name", "start", "description"];
        $optional = ["end", "link", "thumbnail"];

        try {
            $row = $env->db->projects->getRows()[$id];

            foreach ($required as $key) {
                $value = $post[$key] ?? "";

                if (empty($value)) {
                    throw new InvalidArgumentException;
                }

                $row->setColumn($key, ($key === Projects::START) ? (new Carbon($value))->getTimestamp() : $value);
            }

            foreach ($optional as $key) {
                $value = $post[$key] ?? "";

                if (!empty($value)) {
                    $row->setColumn($key, ($key === Projects::END) ? (new Carbon($value))->getTimestamp() : $value);
                }
            }

            $row->store();
        } catch (InvalidArgumentException|InvalidValue $e) {
            $dateFormat = "F j, Y";
            $post->start = (new Carbon($post->start))->format($dateFormat);

            if ($post->end) {
                $post->end = (new Carbon($post->end))->format($dateFormat);
            }

            return new HtmlResponse($blade->run("newProject", ["post" => $post, "edit" => true]));
        }

        return new RedirectResponse("/projects");
    })

    // DO NOT ADD ROUTES BELOW THIS OR THEY WILL NOT WORK //
    ->get("/.*(".\Routes\Files\Files::generateRegex().")", [\Routes\Files\Files::class, "main"])
    ->map404("/(.*)", [\Routes\ErrorHandler::class, "handle404"])
    ->map500("/(.*)", [\Routes\ErrorHandler::class, "handle500"])
;

$router->listen();

echo "Listening on {$env->server->ip}:{$env->server->port}";