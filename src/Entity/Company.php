<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\OneToMany(targetEntity: Patient::class, mappedBy: 'company')]
    private Collection $patients;

    /**
     * @var Collection<int, PatientAccount>
     */
    #[ORM\OneToMany(targetEntity: PatientAccount::class, mappedBy: 'company')]
    private Collection $patientAccounts;

    /**
     * @var Collection<int, AccountEntry>
     */
    #[ORM\OneToMany(targetEntity: AccountEntry::class, mappedBy: 'company')]
    private Collection $accountEntries;

    /**
     * @var Collection<int, Visit>
     */
    #[ORM\OneToMany(targetEntity: Visit::class, mappedBy: 'company')]
    private Collection $visits;

    /**
     * @var Collection<int, VisitItem>
     */
    #[ORM\OneToMany(targetEntity: VisitItem::class, mappedBy: 'company')]
    private Collection $visitItems;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'company')]
    private Collection $payments;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->patientAccounts = new ArrayCollection();
        $this->accountEntries = new ArrayCollection();
        $this->visits = new ArrayCollection();
        $this->visitItems = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setCompany($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, PatientAccount>
     */
    public function getPatientAccounts(): Collection
    {
        return $this->patientAccounts;
    }

    public function addPatientAccount(PatientAccount $patientAccount): static
    {
        if (!$this->patientAccounts->contains($patientAccount)) {
            $this->patientAccounts->add($patientAccount);
            $patientAccount->setCompany($this);
        }

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
            $accountEntry->setCompany($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setCompany($this);
        }

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
            $visitItem->setCompany($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setCompany($this);
        }

        return $this;
    }
}
