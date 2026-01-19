<?php

namespace App\Repository;

use App\Entity\VisitItem;
#use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends TenantAwareRepository<VisitItem>
 */
class VisitItemRepository extends TenantAwareRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitItem::class);
    }
    
    public function findAllForCompany(): array
    {
        return $this->qb('vi')->getQuery()->getResult();
    }

    public function findOneForCompany(int $id): ?Patient
    {
        return $this->qb('vi')
            ->andWhere('vi.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return VisitItem[] Returns an array of VisitItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?VisitItem
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
