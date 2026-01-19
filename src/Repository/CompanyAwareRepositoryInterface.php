<?php

namespace App\Repository;

use App\Security\CompanyContext;

interface CompanyAwareRepositoryInterface
{
    public function setCompanyContext(CompanyContext $companyContext): void;
}
