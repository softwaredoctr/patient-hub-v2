<?php

namespace App\Service;

use App\Entity\AccountEntry;
use App\Entity\Patient;
use App\Entity\User;
use App\Enum\AccountEntryType;
use App\Enum\AccountSourceType;
use App\Security\CompanyContext;
use Doctrine\ORM\EntityManagerInterface;

final class PaymentService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyContext $companyContext
    ) {}

    /**
     * Record a payment received from a patient.
     */
    public function recordPayment(
        Patient $patient,
        string $amount,
        AccountSourceType $sourceType,
        User $actor,
        ?string $description = null
    ): AccountEntry {
        $patientAccount = $patient->getAccount();

        if (!$patientAccount) {
            throw new \LogicException('Patient account does not exist.');
        }

        // Ensure amount is negative (payments reduce balance)
        $negativeAmount = bccomp($amount, '0', 2) === 1
            ? bcmul($amount, '-1', 2)
            : $amount;

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount($patientAccount)
            ->setEntryType(AccountEntryType::PAYMENT)
            ->setAmount($negativeAmount)
            ->setSourceType($sourceType)
            ->setDescription($description)
            ->setCreatedBy($actor);

        $entry->validate();

        $this->em->persist($entry);
        $this->em->flush();

        return $entry;
    }
}
