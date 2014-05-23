<?php
use Aura\Router\Map;
use Aura\Router\DefinitionFactory;
use Aura\Router\RouteFactory;
/*
|--------------------------------------------------------------------------
| Api name and version
|--------------------------------------------------------------------------
*/
define('API', 'Wk2014');
define('VERSION', '0.1.0');
/*
|--------------------------------------------------------------------------
| Error reporting enabled default remove for production
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors',1);
/*
|--------------------------------------------------------------------------
| Auto-Loader
|--------------------------------------------------------------------------
*/
$autoload = include 'vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/
$db = function () {
        try {
        $db = new \PDO('sqlite:' . __DIR__ . '/db/football.db');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    } catch (\PDOException $e) {
        // Log?
        echo $e->getMessage();
    }
};
/*
|--------------------------------------------------------------------------
| set Routes
|--------------------------------------------------------------------------
*/
$map = new Map(new DefinitionFactory, new RouteFactory);
/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

// teams GET
$map->add("teams", "/wk2014.php/groups/{:group}", [
    "params" => [
        "group" => "(\d+)"
    ],
    "values" => [
        "controller" => function ($params) use ($db) {
            $params['db'] = $db();

            return (new Websoftwares\Wk2014\Groups)
                ->getGroup($params)
                ->getResponse();
        }
    ],
     'method' => ['GET']
]);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$route = $map->match($path, $_SERVER);
/*
|--------------------------------------------------------------------------
| Dispatch
|--------------------------------------------------------------------------
*/
if ($route) {
    $params = $route->values;
    $controller = $params["controller"];
    unset($params["controller"]);
    echo $controller($params ? $params : '');
} else {
    header("HTTP/1.0 404 Not Found");
}
