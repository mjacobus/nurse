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

    public function testCallableFunctionReceivesContainerAsArgument()
    {
        $this->object->set('name', function () {
            return 'Jon';
        })
        ->set('lastName', function () {
            return 'Doe';
        })
        ->set('config', function ($container) {
            return array(
                'name'     => $container->get('name'),
                'lastName' => $container->get('lastName'),
            );
        });

        $expactation = array(
            'name'     => 'Jon',
            'lastName' => 'Doe'
        );

        $this->assertEquals($expactation, $this->object->get('config'));
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
