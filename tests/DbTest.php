<?php
namespace Websoftwares\Tests\Wk2014;
use Websoftwares\Wk2014\Db;
/**
 * Class DbTest
 */
class DbTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstanceSucceeds()
    {
        $this->assertInstanceOf('PDO',Db::getInstance());
    }
}
