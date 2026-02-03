<?php

namespace App\Service;

use App\Entity\AccountEntry;
use App\Entity\Company;
use App\Entity\PatientAccount;
use App\Entity\User;
use App\Enum\AccountEntryType;
use App\Enum\AccountSourceType;
use App\Security\CompanyContext;
use Doctrine\ORM\EntityManagerInterface;

final class AdjustmentService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyContext $companyContext
    ) {}

    /**
     * Adjust a patient's balance (refund, write-off, correction).
     */
    public function adjustPatientBalance(
        PatientAccount $account,
        string $amount,
        string $reason,
        User $actor
    ): AccountEntry {
        if (trim($reason) === '') {
            throw new \LogicException('Adjustment reason is required.');
        }

        if (bccomp($amount, '0', 2) === 0) {
            throw new \LogicException('Adjustment amount cannot be zero.');
        }

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount($account)
            ->setEntryType(AccountEntryType::ADJUSTMENT)
            ->setAmount($amount) // +/- allowed
            ->setSourceType(AccountSourceType::MANUAL)
            ->setDescription($reason)
            ->setCreatedBy($actor);

        $entry->validate();

        $this->em->persist($entry);
        $this->em->flush();

        return $entry;
    }

    /**
     * Adjust company ledger (non-patient correction).
     */
    public function adjustCompanyLedger(
        string $amount,
        string $reason,
        User $actor
    ): AccountEntry {
        if (trim($reason) === '') {
            throw new \LogicException('Adjustment reason is required.');
        }

        if (bccomp($amount, '0', 2) === 0) {
            throw new \LogicException('Adjustment amount cannot be zero.');
        }

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount(null)
            ->setEntryType(AccountEntryType::ADJUSTMENT)
            ->setAmount($amount)
            ->setSourceType(AccountSourceType::MANUAL)
            ->setDescription($reason)
            ->setCreatedBy($actor);

        $entry->validate();

        $this->em->persist($entry);
        $this->em->flush();

        return $entry;
    }
}
