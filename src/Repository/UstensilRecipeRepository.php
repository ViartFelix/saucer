<?php

namespace App\Repository;

use App\Entity\UstensilRecipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UstensilRecipe>
 *
 * @method UstensilRecipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method UstensilRecipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method UstensilRecipe[]    findAll()
 * @method UstensilRecipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UstensilRecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UstensilRecipe::class);
    }

//    /**
//     * @return UstensilRecipe[] Returns an array of UstensilRecipe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UstensilRecipe
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
