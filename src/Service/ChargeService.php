<?php

namespace App\Service;

use App\Entity\AccountEntry;
use App\Entity\VisitItem;
use App\Entity\User;
use App\Enum\AccountEntryType;
use App\Enum\AccountSourceType;
use App\Security\CompanyContext;
use Doctrine\ORM\EntityManagerInterface;

final class ChargeService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyContext $companyContext
    ) {}

    /**
     * Confirm a VisitItem as billable and create a CHARGE entry.
     */
    public function chargeVisitItem(
        VisitItem $visitItem,
        User $actor
    ): AccountEntry {
        if ($visitItem->isCharged()) {
            throw new \LogicException('Visit item is already charged.');
        }

        $patient = $visitItem->getVisit()->getPatient();
        $patientAccount = $patient->getAccount();

        if (!$patientAccount) {
            throw new \LogicException('Patient account does not exist.');
        }

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount($patientAccount)
            ->setEntryType(AccountEntryType::CHARGE)
            ->setAmount($visitItem->getAmount()) // positive
            ->setSourceType(AccountSourceType::VISIT_ITEM)
            ->setSourceId($visitItem->getId())
            ->setDescription($visitItem->getName())
            ->setCreatedBy($actor);

        $entry->validate();

        // Mark intent as committed
        $visitItem->markAsCharged();

        $this->em->persist($entry);
        $this->em->persist($visitItem);
        $this->em->flush();

        return $entry;
    }

    /**
     * Remove a previously charged VisitItem.
     * Creates an ADJUSTMENT (negative).
     */
    public function removeCharge(
        VisitItem $visitItem,
        string $reason,
        User $actor
    ): AccountEntry {
        if (!$visitItem->isCharged()) {
            throw new \LogicException('Visit item has not been charged.');
        }

        $patient = $visitItem->getVisit()->getPatient();
        $patientAccount = $patient->getAccount();

        if (!$patientAccount) {
            throw new \LogicException('Patient account does not exist.');
        }

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount($patientAccount)
            ->setEntryType(AccountEntryType::ADJUSTMENT)
            ->setAmount(bcmul($visitItem->getPrice(), '-1', 2)) // negative
            ->setSourceType(AccountSourceType::VISIT_ITEM)
            ->setSourceId($visitItem->getId())
            ->setDescription($reason)
            ->setCreatedBy($actor);

        $entry->validate();

        // Mark intent as cancelled
        $visitItem->markAsCancelled();

        $this->em->persist($entry);
        $this->em->persist($visitItem);
        $this->em->flush();

        return $entry;
    }
}
