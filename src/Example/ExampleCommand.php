<?php

namespace Src\Example;

class ExampleCommand
{
    public function __construct(private ExampleService $exampleService)
    {
    }

    public function execute($arg)
    {
        return $this->exampleService->doSomething($arg);
    }
}