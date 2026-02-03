<?php

namespace App\Entity;

use App\Enum\VisitItemStatus;
use App\Repository\VisitItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitItemRepository::class)]
class VisitItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visitItems')]
    #[ORM\JoinColumn(nullable: false)]
    private Company $company;

    #[ORM\ManyToOne(inversedBy: 'visitItems')]
    #[ORM\JoinColumn(nullable: false)]
    private Visit $visit;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $amount;

    #[ORM\Column(length: 20, enumType: VisitItemStatus::class)]
    private VisitItemStatus $status = VisitItemStatus::DRAFT;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getVisit(): Visit
    {
        return $this->visit;
    }

    public function setVisit(Visit $visit): static
    {
        $this->visit = $visit;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        if ($this->isCharged()) {
            throw new \LogicException('Cannot edit a charged visit item.');
        }
        $this->description = $description;

        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        if ($this->isCharged()) {
            throw new \LogicException('Cannot edit a charged visit item.');
        }
        $this->amount = $amount;

        return $this;
    }
    // --------------------
    // Status helpers
    // --------------------

    public function isCharged(): bool
    {
        return $this->status === VisitItemStatus::CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this->status === VisitItemStatus::CANCELLED;
    }

    public function markAsCharged(): void
    {
        if ($this->status !== VisitItemStatus::DRAFT) {
            throw new \LogicException('Only draft items can be charged.');
        }

        $this->status = VisitItemStatus::CONFIRMED;
    }

    public function markAsCancelled(): void
    {
        if ($this->status !== VisitItemStatus::CONFIRMED) {
            throw new \LogicException('Only charged items can be cancelled.');
        }

        $this->status = VisitItemStatus::CANCELLED;
    }
}
