<?php
namespace Websoftwares\Tests\Wk2014;
use Websoftwares\Wk2014\Teams, Monolog\Logger;
/**
 * Class TeamsTest
 */
class TeamsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->teams = new Teams(new Logger('Wk2014'));
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Wk2014\Teams', $this->teams);
    }

    public function testGetTeamMatchesSucceeds()
    {

        $expectedEN = [
            2 => [
            'play_at' => "2014-06-13 16:00:00",
            'ESP' => "Spain",
            'NED' => "Netherlands"
                ],
            7 => [
                'play_at' => "2014-06-18 13:00:00",
                'AUS' => "Australia",
                'NED' => "Netherlands"
            ],
            12 => [
                'play_at' =>"2014-06-23 13:00:00",
                'NED' => "Netherlands",
                'CHI' =>"Chile"
            ]
        ];

        $expectedNL = [
            2 => [
            'play_at' => "2014-06-13 16:00:00",
            'ESP' => "Spanje",
            'NED' => "Nederland"
                ],
            7 => [
                'play_at' => "2014-06-18 13:00:00",
                'AUS' => "Australië",
                'NED' => "Nederland"
            ],
            12 => [
                'play_at' =>"2014-06-23 13:00:00",
                'NED' => "Nederland",
                'CHI' =>"Chili"
            ]
        ];

        $actualEN = $this->teams->getTeamMatches("NED");
        $this->assertEquals($expectedEN , $actualEN);
        $actualNL = (new Teams(new Logger('Wk2014'), "NL"))->getTeamMatches("NED");
        $this->assertEquals($expectedNL , $actualNL);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTeamMatchesEmpty()
    {
        $this->teams->getTeamMatches();
    }

    /**
     * @expectedException Exception
     */
    public function testInstantiateAsObjectFails()
    {
        new Teams(new \stdClass);
    }
}