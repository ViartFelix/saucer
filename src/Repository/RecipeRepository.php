<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

	public function findSearch($criteria): mixed
	{
		$query = $this
			->createQueryBuilder("r")
		;


		if(!empty($criteria["title"]))
		{
			$query
				->andWhere("r.title LIKE :title")
				->setParameter('title', '%' . $criteria["title"] . '%')
			;
		}

		if(!empty($criteria["description"]))
		{
			$query
				->andWhere("r.description LIKE :description")
				->setParameter('description', '%' . $criteria["description"] . '%')
			;
		}

		if(!empty($criteria["cookTimeMin"]))
		{
			$query
				->andWhere("r.cook_time >= :cookMin")
				->setParameter('cookMin', $criteria["cookTimeMin"])
			;
		}

		if(!empty($criteria["cookTimeMax"]))
		{
			$query
				->andWhere("r.cook_time <= :cookMax")
				->setParameter('cookMax', $criteria["cookTimeMax"])
			;
		}

		if(!empty($criteria["prepTimeMin"]))
		{
			$query
				->andWhere("r.prep_time >= :prepMin")
				->setParameter('prepMin', $criteria["prepTimeMin"])
			;
		}

		if(!empty($criteria["prepTimeMax"]))
		{
			$query
				->andWhere("r.prep_time <= :prepMax")
				->setParameter('prepMax', $criteria["prepTimeMax"])
			;
		}

		if (!empty($criteria['ustensils']) && sizeof($criteria['ustensils']) > 0)
		{
			$query
				->innerJoin('r.ustensils', 'u')
				->andWhere('u IN (:ustensils)')
				->setParameter('ustensils', $criteria['ustensils']);
		}

		if (!empty($criteria['ingredients']) && sizeof($criteria['ingredients']) > 0)
		{
			$query
				->innerJoin('r.recipeIngredients', 'ri')
				->join('ri.ingredient', 'i')
				->andWhere('i IN (:ingredients)')
				->setParameter('ingredients', $criteria['ingredients']);
			;
		}

		return $query->getQuery()->getResult();
	}

//    /**
//     * @return Recipe[] Returns an array of Recipe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recipe
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
