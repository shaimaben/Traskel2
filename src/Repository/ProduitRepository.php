<?php

namespace App\Repository;

use App\Entity\CategorieProd;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function countByDate(){
        $query = $this->createQueryBuilder('a')
            ->select('SUBSTRING(a.createdAt, 1, 10) as dateAnnonces, COUNT(a) as count')
            ->groupBy('dateAnnonces')
         ;
         return $query->getQuery()->getResult();
       // $query = $this->getEntityManager()->createQuery("
       //     SELECT SUBSTRING(a.createdAt, 1, 10) as dateAnnonces, COUNT(a) as count FROM App\Entity\Produit a GROUP BY dateAnnonces
       // ");
       // return $query->getResult();
    }


    public function findAllWithSearch($searchTerm)
{
    $queryBuilder = $this->createQueryBuilder('p');

    if ($searchTerm) {
        $queryBuilder->andWhere('p.nomProd LIKE :searchTerm')
                     ->setParameter('searchTerm', '%' . $searchTerm . '%');
    }

    return $queryBuilder->getQuery()->getResult();
}

public function searchInCategory(CategorieProd $category, string $searchTerm): array
{
    $qb = $this->createQueryBuilder('p')
        ->andWhere('p.idCat = :category')
        ->setParameter('category', $category)
        ->andWhere('p.nomProd LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery();

    return $qb->getResult();
}


//    /**
//     * @return Produit[] Returns an array of Produit objects
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

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}