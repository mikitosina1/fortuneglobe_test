<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * Order class
 *
 * (indexes should optimize WHERE + JOIN + GROUP BY)
 */
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(
    name: 'orders',
    indexes: [
        new ORM\Index(
            name: 'idx_order_pos_date',
            columns: ['point_of_sale_id', 'created_at']
        )
    ]
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $totalAmount;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private PointOfSale $pointOfSale;

    public function __construct(string $totalAmount, PointOfSale $pointOfSale)
    {
        $this->totalAmount = $totalAmount;
        $this->createdAt = new DateTimeImmutable();
        $this->pointOfSale = $pointOfSale;

        /** potentially init POS with new order */
        $pointOfSale->addOrder($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalAmount(): string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPointOfSale(): PointOfSale
    {
        return $this->pointOfSale;
    }

    public function setPointOfSale(PointOfSale $pointOfSale): static
    {
        $this->pointOfSale = $pointOfSale;

        return $this;
    }
}
