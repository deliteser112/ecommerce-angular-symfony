<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;

class CartStateProvider implements ProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy([]);
        return $cart ? $cart->getItems() : [];
    }
}
