<?php

namespace App\Tests\Unit;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAddItem()
    {
        $cart = new Cart();
        $product = new Product();
        $product->setTitle('Test Product')->setPrice(10.00);

        $cartItem = new CartItem($product, 2);
        $cart->addItem($cartItem);

        $this->assertCount(1, $cart->getItems());
        $this->assertSame(2, $cart->getItems()->first()->getAmount());
    }

    public function testRemoveItem()
    {
        $cart = new Cart();
        $product = new Product();
        $product->setTitle('Test Product')->setPrice(10.00);

        $cartItem = new CartItem($product, 2);
        $cart->addItem($cartItem);
        $cart->removeItem($cartItem);

        $this->assertCount(0, $cart->getItems());
    }
}
