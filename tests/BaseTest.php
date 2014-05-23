<?php
namespace Websoftwares\Tests\Wk2014;
use Websoftwares\Wk2014\Base, Monolog\Logger;
/**
 * Class BaseTest
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * $reflection
     * @var \ReflectionClass
     */
    protected $reflection = null;

    public function setUp()
    {
        $this->base = new Base(new Logger('Wk2014'));
        $this->reflection = new \ReflectionClass($this->base);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Wk2014\Base', $this->base);
    }

    public function testGetPropertySucceeds()
    {
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->getProperty('logger'));
    }

    public function testGetTranslationCountriesSucceeds()
    {
        $actual = $this->base->getTranslation("NL", 'countries');
        $this->assertInternalType('array', $actual);
        $this->assertCount(32, $actual);
    }

    public function testGetTranslationCountriesFails()
    {
        $actual = $this->base->getTranslation("EN", 'countries');
        $this->assertInternalType('array', $actual);
        $this->assertEmpty($actual);
        $actual = $this->base->getTranslation("NL", 'xxx');
        $this->assertInternalType('array', $actual);
        $this->assertEmpty($actual);
        $actual = $this->base->getTranslation("NL");
        $this->assertInternalType('array', $actual);
        $this->assertEmpty($actual);
    }

    /**
     * @expectedException Exception
     */
    public function testInstantiateAsObjectFails()
    {
        new Base(new \stdClass);
    }

    public function getProperty($property, $object = null)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object ? $object : $this->base);
    }
}
