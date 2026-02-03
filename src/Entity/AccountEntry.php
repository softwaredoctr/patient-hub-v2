<?php

namespace App\Entity;

use App\Repository\AccountEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\AccountEntryType;
use App\Enum\AccountSourceType;

#[ORM\Entity(repositoryClass: AccountEntryRepository::class)]
class AccountEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'accountEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'accountEntries')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PatientAccount $account = null;

    #[ORM\Column(length: 20, enumType: AccountEntryType::class)]
    private AccountEntryType $entryType;

    /**
     * Stored as string to preserve decimal precision
     * Convention:
     *  - CHARGE     => positive
     *  - PAYMENT    => negative
     *  - EXPENSE    => negative
     *  - ADJUSTMENT => +/- allowed
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $amount;

    #[ORM\Column(length: 20, enumType: AccountSourceType::class)]
    private AccountSourceType $sourceType;

    /**
     * Optional reference ID (e.g. payment_id, visit_item_id)
     */
    #[ORM\Column(nullable: true)]
    private ?int $sourceId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne]
    #[ORM\Column(nullable: true)]
    private ?User $createdBy = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getAccount(): ?PatientAccount
    {
        return $this->account;
    }

    public function setAccount(?PatientAccount $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getEntryType(): ?AccountEntryType
    {
        return $this->entryType;
    }

    public function setEntryType(AccountEntryType  $entryType): static
    {
        $this->entryType = $entryType;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSourceType(): AccountSourceType
    {
        return $this->sourceType;
    }

    public function setSourceType(AccountSourceType $sourceType): self
    {
        $this->sourceType = $sourceType;

        return $this;
    }

    public function getSourceId(): ?int
    {
        return $this->sourceId;
    }

    public function setSourceId(?int $sourceId): static
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?int $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    // --------------------
    // Ledger invariants
    // --------------------

    /**
     * Call this before persisting.
     * Enforces v2 financial rules.
     */
    public function validate(): void
    {
        if (
            $this->entryType === AccountEntryType::EXPENSE &&
            $this->account !== null
        ) {
            throw new \LogicException(
                'Expense entries must not be linked to a patient account.'
            );
        }

        if (
            \in_array(
                $this->entryType,
                [AccountEntryType::CHARGE, AccountEntryType::PAYMENT],
                true
            ) &&
            $this->account === null
        ) {
            throw new \LogicException(
                'Charge and payment entries require a patient account.'
            );
        }
    }
}
