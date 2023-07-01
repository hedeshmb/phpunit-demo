<?php

use PHPUnit\Framework\TestCase;
use Src\Cart;

class CartTest extends TestCase
{
    protected Cart $cart;

    protected function setUp(): void
    {
        $this->cart = new Cart();
    }

    protected function tearDown(): void
    {
        Cart::$tax = 1.2;
    }

    public function testTheCartTaxValueCanBeChangedStatically()
    {
        Cart::$tax = 1.5;
        $this->cart->price = 10;
        $netPrice = $this->cart->getNextPrice();

        $this->assertEquals(15, $netPrice);

    }

    public function testCorrectNetPriceIsReturned()
    {
        $this->cart->price = 10;
        $netPrice = $this->cart->getNextPrice();

        $this->assertEquals(12, $netPrice);
    }

    public function test_a_type_error_is_thrown_when_trying_to_add_a_non_int_to_the_price()
    {
        try {
            $this->cart->addToPrice('fifteen');
            $this->fail('A TypeError should have been thrown');
        } catch (TypeError $error) {
            $this->assertStringStartsWith('Src\Cart::addToPrice():', $error->getMessage());
        }
    }
}