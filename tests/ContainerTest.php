<?php

namespace NurseTest;

use Dummy\Connection;
use Nurse\Container;
use Nurse\Container\Exception\UndefinedDependencyException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    public $object;

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
        $other = $this->object->get('connection');

        $this->assertSame($connection, $other);
    }

    /**
     * @test
     * @expectedException \Nurse\Container\Exception\DependencyAlreadyDefinedException
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

        $this->assertTrue(true);
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
            return [
                'name'     => $container->get('name'),
                'lastName' => $container->get('lastName'),
            ];
        });

        $expactation = [
            'name'     => 'Jon',
            'lastName' => 'Doe',
        ];

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
     * @expectedException \Psr\Container\NotFoundExceptionInterface
     * @expectedExceptionMessage 'invalid_key' was not defined
     */
    public function getWithUndefinedKeyThrowsException()
    {
        $this->object->get('invalid_key');
    }

    /**
     * @expectedException \Psr\Container\ContainerExceptionInterface
     * @expectedExceptionMessage Error creating object with key 'foo'
     * @test
     */
    public function throwsContainerExceptionWhenTheFactoryFails()
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
     * @expectedException \Nurse\Container\Exception\UndefinedDependencyException
     * @expectedExceptionMessage Undefined bro
     * @test
     */
    public function throwsOriginalContainerExceptionWhenExceptionIsAContainerException()
    {
        $original = new UndefinedDependencyException('Undefined bro');

        $callback = function () use ($original) {
            throw $original;
        };

        $this->object->set('foo', $callback);
        $this->object->get('foo');
    }

    /**
     * @test
     */
    public function implementsInteropContainerInterface()
    {
        $this->assertInstanceOf(
            'Psr\Container\ContainerInterface',
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

    /**
     * @test
     */
    public function canAddFactories()
    {
        $factory = new \Dummy\MyDummyFactory();

        $config = ['some' => 'config'];

        $this->object->set('someConfig', function () use ($config) {
            return $config;
        });

        $expected = new \Dummy\Connection($config);

        $actual = $this->object->addFactory($factory)->get('theKey');

        $this->assertEquals($expected, $actual);
    }
}
