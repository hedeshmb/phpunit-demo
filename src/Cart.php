<?php

namespace Src;
class Cart
{
    public float $price;
    public static float $tax = 1.2;

    public function getNextPrice(): float
    {
        return $this->price * self::$tax;
    }

    public function addToPrice(int $amount) {
        $this->price += $amount;
    }

}