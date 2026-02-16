<?php

namespace App\Repository;

use App\Security\CompanyContext;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class TenantAwareRepository extends ServiceEntityRepository implements CompanyAwareRepositoryInterface
{
    protected CompanyContext $companyContext;

    public function setCompanyContext(CompanyContext $companyContext): void
    {
        $this->companyContext = $companyContext;
    }

    protected function qb(string $alias)
    {
        $qb = $this->createQueryBuilder($alias);

        $company = $this->companyContext->getCompany();

        if ($company !== null) {
            $qb
                ->andWhere($alias . '.company = :company')
                ->setParameter('company', $company);
        }

        return $qb;
    }
}
