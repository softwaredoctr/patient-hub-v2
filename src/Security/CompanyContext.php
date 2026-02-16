<?php

namespace App\Security;

use App\Entity\Company;
use Symfony\Bundle\SecurityBundle\Security;

class CompanyContext
{
    private ?Company $company = null;

    public function __construct(
        private Security $security
    ) {}

    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    public function getCompany(): ?Company
    {
        // Super admin has global scope
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return null;
        }

        if ($this->company === null) {
            throw new \LogicException('No company set in CompanyContext.');
        }

        return $this->company;
    }
}