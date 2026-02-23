<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\PointOfSaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointOfSaleRepository::class)]
class PointOfSale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private bool $isActive;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'pointOfSale')]
    private Collection $orders;

    public function __construct(string $name, bool $isActive = true)
    {
        $this->orders = new ArrayCollection();
        $this->name = $name;
        $this->isActive = $isActive;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * Adds Order to point of sale
     * @param Order $order
     * @return static
     */
    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setPointOfSale($this);
        }

        return $this;
    }

    /**
     * Removes Order from point of sale
     * @param Order $order
     * @return static
     */
    public function removeOrder(Order $order): static
    {
        $this->orders->removeElement($order);

        return $this;
    }

    public function hasOrders(): bool
    {
        /**
         * here's possibly to use: return count($this->orders) > 0;
         * but not to touch SQL when it's not necessary:
         */
        return !$this->orders->isEmpty();
    }
}
