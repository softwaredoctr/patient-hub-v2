<?php

namespace App\Entity;

use App\Repository\PatientAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientAccountRepository::class)]
#[ORM\Table(
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'uq_company_patient', 
            columns: ['company_id', 'patient_id']
        )
    ]
)]
class PatientAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'patientAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    /**
     * @var Collection<int, AccountEntry>
     */
    #[ORM\OneToMany(targetEntity: AccountEntry::class, mappedBy: 'account')]
    private Collection $accountEntries;

    public function __construct()
    {
        $this->accountEntries = new ArrayCollection();
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

    /**
     * @return Collection<int, AccountEntry>
     */
    public function getAccountEntries(): Collection
    {
        return $this->accountEntries;
    }

    public function addAccountEntry(AccountEntry $accountEntry): static
    {
        if (!$this->accountEntries->contains($accountEntry)) {
            $this->accountEntries->add($accountEntry);
            $accountEntry->setAccount($this);
        }

        return $this;
    }

    public function removeAccountEntry(AccountEntry $accountEntry): static
    {
        if ($this->accountEntries->removeElement($accountEntry)) {
            // set the owning side to null (unless already changed)
            if ($accountEntry->getAccount() === $this) {
                $accountEntry->setAccount(null);
            }
        }

        return $this;
    }
}
