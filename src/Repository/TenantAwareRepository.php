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
        return $this->createQueryBuilder($alias)
            ->andWhere($alias . '.company = :company')
            ->setParameter('company', $this->companyContext->getCompany());
    }
}
