<?php

namespace App\Repository;

use App\Entity\PatientAccount;
#use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends TenantAwareRepository<PatientAccount>
 */
class PatientAccountRepository extends TenantAwareRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientAccount::class);
    }
    public function findAllForCompany(): array
    {
        return $this->qb('pa')->getQuery()->getResult();
    }

    public function findOneForCompany(int $id): ?PatientAccount
    {
        return $this->qb('pa')
            ->andWhere('pa.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return PatientAccount[] Returns an array of PatientAccount objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PatientAccount
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
