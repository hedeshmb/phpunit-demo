<?php

namespace Src\Example;

class ExampleService
{
    private $paramOne;
    private $paramTwo;

    /**
     * @param $paramOne
     * @param $paramTwo
     */
    public function __construct($paramOne, $paramTwo)
    {
        $this->paramOne = $paramOne;
        $this->paramTwo = $paramTwo;
    }

    public function doSomething($arg)
    {
        return 'Some random text';
    }

    public function nonMockedMethod($arg)
    {
        return $this->doSomething($arg);
    }


}