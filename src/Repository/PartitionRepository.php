<?php

namespace App\Repository;

use App\Entity\Partition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partition>
 *
 * @method Partition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partition[]    findAll()
 * @method Partition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partition::class);
    }

//    /**
//     * @return Partition[] Returns an array of Partition objects
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

//    public function findOneBySomeField($value): ?Partition
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
