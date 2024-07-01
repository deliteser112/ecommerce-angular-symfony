<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartStateProcessor implements ProcessorInterface
{
    private $entityManager;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $method = $request->getMethod();

        if ($method === 'PUT') {
            $this->handleAddToCart($data);
        } elseif ($method === 'DELETE') {
            $this->handleRemoveFromCart($data);
        }
    }

    private function handleAddToCart(Product $product)
    {
        $request = $this->requestStack->getCurrentRequest();
        $content = json_decode($request->getContent(), true);
        $amount = $content['amount'] ?? 1;

        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy([]) ?? new Cart();
        $cartItem = new CartItem($product, $amount);
        $cart->addItem($cartItem);

        $this->entityManager->persist($cartItem);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    private function handleRemoveFromCart(Product $product)
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy([]);
        if (!$cart) {
            return;
        }

        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $cart->removeItem($item);
                $this->entityManager->persist($cart);
                $this->entityManager->remove($item);
                $this->entityManager->flush();
                return;
            }
        }
    }
}
