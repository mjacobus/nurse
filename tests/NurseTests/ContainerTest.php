<?php

namespace NurseTests;

use PHPUnit_Framework_TestCase;
use Nurse\Container;
use Dummy\Connection;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    public $container;

    public function setUp()
    {
        $this->object = new Container();
    }

    /**
     * @test
     */
    public function getReturnsTheValueOfTheFunction()
    {
        $this->object->set('connection', function () {
            return new Connection();
        });

        $this->assertInstanceOf('Dummy\Connection', $this->object->get('connection'));
    }

    /**
     * @test
     */
    public function getCachesFunction()
    {
        $this->object->set('connection', function () {
            return new Connection();
        });

        $connection = $this->object->get('connection');
        $other      = $this->object->get('connection');

        $this->assertSame($connection, $other);
    }

    /**
     * @test
     * @expectedException \Nurse\DependencyAlreadyDefinedException
     * @expectedExceptionMessage 'foo' was already defined
     */
    public function setThrowsExceptionWhenWasAlreadyDefined()
    {
        $definition = function () {
        };

        $this->object->set('foo', $definition);
        $this->object->set('foo', $definition);
    }

    /**
     * @test
     */
    public function getLazyLoadsFunction()
    {
        $this->object->set('connection', function () {
            throw new \Exception();
        });
    }

    /**
     * @test
     */
    public function callableFunctionReceivesContainerAsArgument()
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
            'lastName' => 'Doe',
        );

        $this->assertEquals($expactation, $this->object->get('config'));
    }

    /**
     * @test
     */
    public function setReturnsSelf()
    {
        $return = $this->object->set('connection', function () {
            return;
        });

        $this->assertSame($this->object, $return);
    }

    /**
     * @test
     * @expectedException \Interop\Container\Exception\NotFoundException
     * @expectedExceptionMessage 'invalid_key' was not defined
     */
    public function getWithUndefinedKeyThrowsException()
    {
        $this->object->get('invalid_key');
    }

    /**
     * @expectedException \Interop\Container\Exception\ContainerException
     * @expectedExceptionMessage Error creating object with key 'foo'
     * @test
     */
    public function throwsContainerExeptionWhenTheFactoryFails()
    {
        try {
            $original = new \Exception('foo');

            $this->object->set('foo', function () use ($original) {
                throw $original;
            })->get('foo');
        } catch (\Exception $e) {
            $this->assertSame($original, $e->getPrevious());
            throw $e;
        }
    }

    /**
     * @test
     */
    public function implementsInteropContainerInterface()
    {
        $this->assertInstanceOf(
            'Interop\Container\ContainerInterface',
            $this->object
        );
    }

    /**
     * @test
     */
    public function returnsBooleanIndicatingIfDependencyWasDefined()
    {
        $this->assertFalse($this->object->has('connection'));

        $definition = function () {
        };

        $this->object->set('connection', $definition);
        $this->assertTrue($this->object->has('connection'));
    }
}
