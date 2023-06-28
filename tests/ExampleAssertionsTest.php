<?php

class ExampleAssertionsTest extends \PHPUnit\Framework\TestCase
{
    public function testThatStringMatch()
    {
        $string1 = 'testing';
        $string2 = 'testing';
        $string3 = 'Testing';

        $this->assertSame($string1, $string2);
        $this->assertSame($string3, $string2);
    }

    public function testThatNumbersAddUo() {
        $this->assertEquals(10, 5+5 +1);
    }
}