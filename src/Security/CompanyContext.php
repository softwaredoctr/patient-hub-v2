<?php

namespace App\Security;

use App\Entity\Company;

class CompanyContext
{
    private ?Company $company = null;

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function getCompany(): Company
    {
        if ($this->company === null) {
            throw new \LogicException('No company set in CompanyContext.');
        }

        return $this->company;
    }
}
