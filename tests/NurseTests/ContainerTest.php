<?php

namespace NurseTests;

use PHPUnit_Framework_TestCase;
use Nurse\Container;
use Nurse\Di;
use Dummy\Connection;

class ContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Container
     */
    public $container;

    public function setUp()
    {
        $this->object = new Container;
    }

    public function testExisteClasse()
    {
        $this->assertInstanceOf('Nurse\Container', new Container);
    }

    public function testGetReturnsTheValueOfTheFunction()
    {
        $this->object->set('connection', function () {
            return new Connection;
        });

        $this->assertInstanceOf('Dummy\Connection', $this->object->get('connection'));
    }

    public function testGetCachesFunction()
    {
        $this->object->set('connection', function () {
            return new Connection;
        });

        $connection = $this->object->get('connection');
        $other      = $this->object->get('connection');

        $this->assertSame($connection, $other);
    }

    public function testGetLazyLoadsFunction()
    {
        $this->object->set('connection', function () {
            throw new \Exception;
        });
    }

    public function testSetReturnsSelf()
    {
        $return = $this->object->set('connection', function () {
            return null;
        });

        $this->assertSame($this->object, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 'invalid_key' was not defined
     */
    public function testGetWithUndefinedKeyThrowsException()
    {
        $this->object->get('invalid_key');
    }
}
