<?php

namespace App\Repository;

use App\Entity\Categoriecad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoriecad>
 *
 * @method Categoriecad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoriecad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoriecad[]    findAll()
 * @method Categoriecad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriecadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoriecad::class);
    }

//    /**
//     * @return Categoriecad[] Returns an array of Categoriecad objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categoriecad
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
