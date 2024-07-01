<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\CartStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(
            provider: CartStateProvider::class, 
            uriTemplate: '/cart',
            openapi: new Operation(
                summary: 'Retrieves cart content'
            )
        )
    ]
)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CartItem $cartItem): self
    {
        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $cartItem->getProduct()->getId()) {
                $item->setAmount($item->getAmount() + $cartItem->getAmount());
                return $this;
            }
        }
        $this->items->add($cartItem);
        $cartItem->setCart($this);
        return $this;
    }

    public function removeItem(CartItem $cartItem): self
    {
        $this->items->removeElement($cartItem);
        return $this;
    }
}
