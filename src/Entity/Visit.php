<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\VisitStatus;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $visitDate = null;

    #[ORM\Column(length: 20, enumType: VisitStatus::class)]
    private ?VisitStatus $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, VisitItem>
     */
    #[ORM\OneToMany(targetEntity: VisitItem::class, mappedBy: 'visit')]
    private Collection $visitItems;

    public function __construct()
    {
        $this->visitItems = new ArrayCollection();
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

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getVisitDate(): ?\DateTimeImmutable
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeImmutable $visitDate): static
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, VisitItem>
     */
    public function getVisitItems(): Collection
    {
        return $this->visitItems;
    }

    public function addVisitItem(VisitItem $visitItem): static
    {
        if (!$this->visitItems->contains($visitItem)) {
            $this->visitItems->add($visitItem);
            $visitItem->setVisit($this);
        }

        return $this;
    }

    public function removeVisitItem(VisitItem $visitItem): static
    {
        if ($this->visitItems->removeElement($visitItem)) {
            // set the owning side to null (unless already changed)
            if ($visitItem->getVisit() === $this) {
                $visitItem->setVisit(null);
            }
        }

        return $this;
    }
}
