<?php

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartItem;

class FeatureContext implements Context
{
    private $cart;
    private $product;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    /**
     * @Given I have a product with id :id and title :title
     */
    public function iHaveAProductWithIdAndTitle($id, $title)
    {
        $this->product = new Product();
        $this->product->setId($id)->setTitle($title);
    }

    /**
     * @When I add :quantity quantity of product :id to the cart
     */
    public function iAddQuantityOfProductToTheCart($quantity, $id)
    {
        $cartItem = new CartItem($this->product, $quantity);
        $this->cart->addItem($cartItem);
    }

    /**
     * @Then the cart should contain :count item
     */
    public function theCartShouldContainItem($count)
    {
        Assert::assertCount($count, $this->cart->getItems());
    }

    /**
     * @Then the item should have a quantity of :quantity
     */
    public function theItemShouldHaveAQuantityOf($quantity)
    {
        Assert::assertSame($quantity, $this->cart->getItems()->first()->getAmount());
    }

    /**
     * @When I remove product :id from the cart
     */
    public function iRemoveProductFromTheCart($id)
    {
        $cartItem = $this->cart->getItems()->first();
        $this->cart->removeItem($cartItem);
    }

    /**
     * @Then the cart should be empty
     */
    public function theCartShouldBeEmpty()
    {
        Assert::assertCount(0, $this->cart->getItems());
    }
}
