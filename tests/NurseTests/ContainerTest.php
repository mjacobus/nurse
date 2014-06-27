<?php

namespace NurseTests;

use PHPUnit_Framework_TestCase;
use Nurse\Container;
use Nurse\Di;
use Dummy\Connection;

class ContainerTest extends PHPUnit_Framework_TestCase
{

    public function testExisteClasse()
    {
        $this->assertInstanceOf('Nurse\Container', new Container);
    }

    public function testRetornoCorreto()
    {
        $object = new Container;

        $object->set('connection', function () {
            return new Connection;
        });

        $this->assertInstanceOf('Dummy\Connection', $object->get('connection'));
    }

    public function testGetFazCacheDoResultadoDaFuncao()
    {
        $object = new Container;

        $object->set('connection', function () {
            return new Connection;
        });

        $connection = $object->get('connection');
        $other      = $object->get('connection');

        $this->assertSame($connection, $other);
    }

    public function testGetFazLazyLoadingDaFuncao()
    {
        $object = new Container;

        $object->set('connection', function () {
            throw new \Exception;
        });
    }
}
