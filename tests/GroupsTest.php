<?php
namespace Websoftwares\Tests\Wk2014;
use Websoftwares\Wk2014\Groups, Monolog\Logger;
/**
 * Class GroupsTest
 */
class GroupsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * $reflection
     * @var \ReflectionClass
     */
    protected $reflection = null;

    public function setUp()
    {
        $this->groups = new Groups(new Logger('Wk2014'));
        $this->reflection = new \ReflectionClass($this->groups);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Wk2014\Groups', $this->groups);
    }

    public function testGetPropertySucceeds()
    {
        $this->assertEquals("EN",$this->groups->language);
    }

    public function testGetGroupSucceeds()
    {
        $expected = [
            'event' => "world.2014",
            'group' => 2,
            'teams' => []
        ];

        $expectedEN = [
            'AUS' => "Australia",
            'CHI' => "Chile",
            'NED' => "Netherlands",
            'ESP' => "Spain"
        ];

        $expectedNL = [
            'AUS' => "Australië",
            'CHI' => "Chili",
            'NED' => "Nederland",
            'ESP' => "Spanje"
        ];

        $expected['teams'] = $expectedEN;
        $actualEN = $this->groups->getGroup(2);
        $this->assertEquals($expected, $actualEN);
        $expected['teams'] = $expectedNL;
        $actualNL = (new Groups(new Logger('Wk2014'), "NL"))->getGroup(2);
        $this->assertEquals($expected, $actualNL);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetGroupFailsEmpty()
    {
        $this->groups->getGroup();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetGroupFailsTypeMisMatch()
    {
        $this->groups->getGroup('String');
    }

    /**
     * @expectedException Exception
     */
    public function testInstantiateAsObjectFails()
    {
        new Groups(new \stdClass);
    }
}
