<?php
namespace Websoftwares\Wk2014;
/**
* DB class
*
* @package Websoftwares
* @subpackage Wk2014
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class Db
{
    /**
     * getInstance returns sqlite PDO database connection
     * @return \PDO
     */
    public static function getInstance()
    {
        $db = new \PDO('sqlite:' . __DIR__ . '/../vendor/openfootball/build/worldcup2014.db');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
