<?php

namespace App\Service;

use App\Entity\AccountEntry;
use App\Entity\Company;
use App\Entity\User;
use App\Enum\AccountEntryType;
use App\Enum\AccountSourceType;
use App\Security\CompanyContext;
use Doctrine\ORM\EntityManagerInterface;

final class ExpenseService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyContext $companyContext
    ) {}

    /**
     * Record a company expense (e.g. petty cash, supplies).
     */
    public function recordExpense(
        string $amount,
        AccountSourceType $sourceType,
        string $description,
        User $actor
    ): AccountEntry {
        if (trim($description) === '') {
            throw new \LogicException('Expense description is required.');
        }

        // Ensure amount is negative
        $negativeAmount = bccomp($amount, '0', 2) === 1
            ? bcmul($amount, '-1', 2)
            : $amount;

        $entry = new AccountEntry();
        $entry
            ->setCompany($this->companyContext->getCompany())
            ->setAccount(null)
            ->setEntryType(AccountEntryType::EXPENSE)
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
