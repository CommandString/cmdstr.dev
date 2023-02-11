<?php

namespace Routes;

use Carbon\Carbon;
use CommandString\Pdo\Sql\Operators;
use CommandString\Utils\GeneratorUtils;
use Common\Env;
use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use HttpSoft\Response\RedirectResponse;
use InvalidArgumentException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Projects {
    public static function main(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade): ResponseInterface
    {
        $driver = Env::getDriver();
        $dateFormat = "n/j/Y";

        $result = $driver->select()->from("projects")->orderBy("start", Operators::DESCENDING)->execute();

        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

            if ($row["end"]) {
                $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
            }
        }
        
        return new HtmlResponse($blade->run("projects", ["projects" => $rows]));
    }

    public static function getNew(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade): ResponseInterface
    {   
        return new HtmlResponse($blade->run("newProject"));
    }

    public static function postNew(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade): ResponseInterface
    {
        $driver = Env::getDriver();

        $post = $req->getParsedBody();
        $query = $driver->insert()->into("projects");

        $required = ["name", "start", "description", "thumbnail"];
        $optional = ["end", "link"];
        $errors = [];

        foreach ($required as $key) {
            $value = $post[$key] ?? "";

            if (empty($value)) {
                $errors[] = ucfirst($key)." is required!";
            }

            if ($key === "start") {
                $value = (new Carbon($value))->getTimestamp();
            }

            $query->value($key, $value);
        }

        foreach ($optional as $key) {
            $value = $post[$key] ?? "";

            if (!empty($value)) {
                if ($key === "end") {
                    $value = (new Carbon($value))->getTimestamp();
                }

                $query->value($key, $value);
            }
        }

        if (empty($errors)) {
            $query->execute();
            return new RedirectResponse("/projects");
        } else {
            return new HtmlResponse($blade->run("newProject", ["post" => $post, "errors" => $errors]));
        }
    }

    public static function getEdit(ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) {
        $env = Env::get();

        $driver = Env::getDriver();

        $result = $driver->select()->from("projects")->where("id", Operators::EQUAL_TO, $id)->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new RedirectResponse("/dev/projects/new");
        }

        $dateFormat = "F j, Y";
        $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

        if ($row["end"]) {
            $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
        }
        
        return new HtmlResponse($blade->run("newProject", ["post" => $row, "edit" => true]));
    }

    public static function postEdit(ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) {
        $post = $req->getParsedBody();

        $required = ["name", "start", "description"];
        $optional = ["end", "link", "thumbnail"];
        $driver = Env::getDriver();

        $query = "UPDATE projects SET";
        $values = [];
        $errors = [];

        foreach ($required as $key) {
            $value = $post[$key] ?? "";

            if (empty($value)) {
                $errors[] = ucfirst($key)." is required!";
            }

            $valueId = GeneratorUtils::uuid(5);
            $values[$valueId] = ($key === "start") ? (new Carbon($value))->getTimestamp() : $value;

            $query .= " $key = :$valueId,";
        }

        foreach ($optional as $key) {
            $value = $post[$key] ?? "";
            $valueId = GeneratorUtils::uuid(5);

            if (!empty($value)) {
                $values[$valueId] = ($key === "end") ? (new Carbon($value))->getTimestamp() : $value;

                $query .= " $key = :$valueId,";
            } else {
                $query .= " $key = :$valueId,";
                $values[$valueId] = null;
            }
        }

        $query = substr($query, 0, -1);

        $query .= " WHERE id = :id";

        $values["id"] = $id;

        if (empty($errors)) {
            $driver->prepare($query);
            $driver->execute($values);

            return new RedirectResponse("/projects");
        }

        $dateFormat = "F j, Y";
        $post['start'] = (new Carbon($post["start"]))->format($dateFormat);

        if ($post['end']) {
            $post['end'] = (new Carbon($post["end"]))->format($dateFormat);
        }

        return new HtmlResponse($blade->run("newProject", ["post" => $post, "edit" => true, "errors" => $errors]));
    }
}