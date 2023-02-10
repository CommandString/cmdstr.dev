<?php

namespace Routes;

use Carbon\Carbon;
use CommandString\JsonDb\Exceptions\InvalidValue;
use CommandString\JsonDb\Exceptions\UniqueRowViolation;
use Common\Env;
use eftec\bladeone\BladeOne;
use HttpSoft\Response\HtmlResponse;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Database\Projects\Projects as ProjectsDb;
use HttpSoft\Response\RedirectResponse;

class Projects {
    public static function main(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) {
        $env = Env::get();

        $projects = $env->db->projects;
        $rows = $projects->newQuery()->execute();
        $dateFormat = "n/j/Y";

        usort($rows, function ($a, $b) {
            return ($a->start < $b->start);
        });

        foreach (array_keys($rows) as $key) {
            $row = & $rows[$key];
            $row = $row->jsonSerialize();

            $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

            if ($row["end"]) {
                $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
            }
        }

        return new HtmlResponse($blade->run("projects", ["projects" => $rows]));
    }

    public static function getNew(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) {
        return new HtmlResponse($blade->run("newProject"));
    }

    public static function postNew(ServerRequestInterface $req, ResponseInterface $res, BladeOne $blade) {
        $env = Env::get();

        $post = $req->getParsedBody();

        $required = ["name", "start", "description"];
        $optional = ["end", "link", "thumbnail"];

        try {
            $row = $env->db->projects->newRow();

            foreach ($required as $key) {
                $value = $post[$key] ?? "";

                if (empty($value)) {
                    throw new InvalidArgumentException();
                }

                $row->setColumn($key, ($key === ProjectsDb::START) ? (new Carbon($value))->getTimestamp() : $value);
            }

            foreach ($optional as $key) {
                $value = $post[$key] ?? "";

                if (!empty($value)) {
                    $row->setColumn($key, ($key === ProjectsDb::END) ? (new Carbon($value))->getTimestamp() : $value);
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
    }

    public static function getEdit(ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) {
        $env = Env::get();

        $row = $env->db->projects->getRows()[$id] ?? null;

        if (is_null($row)) {
            return new RedirectResponse("/projects");
        }

        $row = $row->jsonSerialize();
        
        $dateFormat = "F j, Y";
        $row["start"] = (new Carbon($row["start"]))->format($dateFormat);

        if ($row["end"]) {
            $row["end"] = (new Carbon($row["end"]))->format($dateFormat);
        }
        
        return new HtmlResponse($blade->run("newProject", ["post" => $row, "edit" => true]));
    }

    public static function postEdit(ServerRequestInterface $req, ResponseInterface $res, $id, BladeOne $blade) {
        $env = Env::get();

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

                $row->setColumn($key, ($key === ProjectsDb::START) ? (new Carbon($value))->getTimestamp() : $value);
            }

            foreach ($optional as $key) {
                $value = $post[$key] ?? "";

                if (!empty($value)) {
                    $row->setColumn($key, ($key === ProjectsDb::END) ? (new Carbon($value))->getTimestamp() : $value);
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
    }
}