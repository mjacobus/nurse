<?php

namespace NurseTests;

use PHPUnit_Framework_TestCase;
use Nurse\Di;
use Dummy\Connection;

class DiTest extends PHPUnit_Framework_TestCase
{
    public function testCanSetAndGetValues()
    {
        Di::set('connection', function () {
            return new Connection();
        });

        $connection = Di::get('connection');

        $this->assertInstanceOf('Dummy\Connection', $connection);
        $this->assertSame($connection, Di::get('connection'));
    }

    public function testSetReturnsContainer()
    {
        $container = Di::set('foo', function () {
            return 'foo';
        });

        $this->assertInstanceOf('Nurse\Container', $container);
    }
}
