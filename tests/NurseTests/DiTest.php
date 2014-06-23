<?php

namespace NurseTests;

use PHPUnit_Framework_TestCase;

use Nurse\Di;

class DiTest extends PHPUnit_Framework_TestCase
{
    public function testCanLoadClass()
    {
        $this->assertInstanceOf('Nurse\Di', new Di);
    }
}
