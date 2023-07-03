<?php

use PHPUnit\Framework\TestCase;

class TestDoublesTest extends TestCase
{
    public function testMock()
    {
        $stub = $this->createStub(\Src\Example\ExampleService::class);

        $stub->expects($this->once())
            ->method('doSomething')
            ->with('banana')
            ->willReturn('food');

        $exampleCommand = new \Src\Example\ExampleCommand($stub);

        $this->assertSame('food', $exampleCommand->execute('banana'));
    }

    public function testReturnTypes()
    {
        $mock = $this->createMock(\Src\Example\ExampleService::class);
        $this->assertNull($mock->doSomething('banana'));
    }

    public function testConsecutiveReturns()
    {
        $stub = $this->createStub(\Src\Example\ExampleService::class);
        $stub->method('doSomething')
            ->willReturnOnConsecutiveCalls(1, 2);

        foreach ([1, 2] as $value) {
            $this->assertSame($value, $stub->doSomething('banana'));
        }
    }

    public function testExceptionsThrown()
    {
        $stub = $this->createStub(\Src\Example\ExampleService::class);

        $stub->method('doSomething')
            ->willThrowException(new RuntimeException());

        $this->expectException(RuntimeException::class);

        $stub->doSomething('banana');
    }

    public function testCallbackReturns()
    {
        $stub = $this->createStub(\Src\Example\ExampleService::class);
        $stub->method('doSomething')
            ->willReturnCallback(function ($arg) {
                if ($arg % 2 == 0) {
                    return $arg;
                }
                throw new InvalidArgumentException();
            });

        $this->assertSame(10, $stub->doSomething(10));

        $this->expectException(InvalidArgumentException::class);
        $stub->doSomething(9);
    }

    public function testWithEqualTo()
    {
        $mock = $this->createMock(\Src\Example\ExampleService::class);

        $mock->expects($this->once())
            ->method('doSomething')
            ->with($this->equalTo('bar'));

        $mock->doSomething('bar');
    }

    public function testMultipleArgs()
    {
        $mock = $this->createMock(\Src\Example\ExampleService::class);

        $mock->expects($this->once())
            ->method('doSomething')
            ->with(
                $this->stringContains('foo'),
                $this->greaterThanOrEqual(100),
                $this->anything()
            );

        $mock->doSomething('foobar', 101, null);
    }

    public function testIdenticalTo()
    {
        $dependency = new \Src\Example\ExampleDependency();

        $mock = $this->createMock(\Src\Example\ExampleService::class);

        $mock->expects($this->once())
            ->method('doSomething')
            ->with($this->identicalTo($dependency));

       $mock->doSomething($dependency);
    }

    public function testMockBuilder()
    {
        $mock = $this->getMockBuilder(\Src\Example\ExampleService::class)
            ->setConstructorArgs([100, 200])
            ->getMock();

        $mock->method('doSomething')->willReturn('foo');

        $this->assertSame('foo', $mock->doSomething('bar'));
    }

    public function testOnlyMethods()
    {
        $mock = $this->getMockBuilder(\Src\Example\ExampleService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['doSomething'])
            ->getMock();

        $mock->method('doSomething')->willReturn('foo');

        $this->assertSame('foo', $mock->nonMockedMethod('bar'));
    }

    public function testAddMethods()
    {
        $mock = $this->getMockBuilder(\Src\Example\ExampleService::class)
            ->disableOriginalConstructor()
            ->addMethods(['nonExistentMethod'])
            ->getMock();

        $mock->expects($this->once())
            ->method('nonExistentMethod')
            ->with($this->isInstanceOf(\Src\Example\ExampleDependency::class))
            ->willReturn('foo');

        $this->assertSame('foo', $mock->nonExistentMethod(new \Src\Example\ExampleDependency()));

    }

}