<?php

namespace App\Repository;

use App\Entity\LivraisonsCadeaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivraisonsCadeaux>
 *
 * @method LivraisonsCadeaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivraisonsCadeaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivraisonsCadeaux[]    findAll()
 * @method LivraisonsCadeaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonsCadeauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivraisonsCadeaux::class);
    }

//    /**
//     * @return LivraisonsCadeaux[] Returns an array of LivraisonsCadeaux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LivraisonsCadeaux
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
