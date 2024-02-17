<?php

namespace App\Repository;

use App\Entity\Checkdon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Checkdon>
 *
 * @method Checkdon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkdon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkdon[]    findAll()
 * @method Checkdon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckdonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkdon::class);
    }

//    /**
//     * @return Checkdon[] Returns an array of Checkdon objects
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

//    public function findOneBySomeField($value): ?Checkdon
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
