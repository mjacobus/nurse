<?php

namespace NurseTest;

use Dummy\Connection;
use Nurse\Di;
use PHPUnit\Framework\TestCase;

class DiTest extends TestCase
{
    /**
     * @test
     */
    public function canSetAndGetValues()
    {
        Di::set('connection', function () {
            return new Connection();
        });

        $connection = Di::get('connection');

        $this->assertInstanceOf('Dummy\Connection', $connection);
        $this->assertSame($connection, Di::get('connection'));
    }

    /**
     * @test
     */
    public function setReturnsContainer()
    {
        $container = Di::set('foo', function () {
            return 'foo';
        });

        $this->assertInstanceOf('Nurse\Container', $container);
    }
}
