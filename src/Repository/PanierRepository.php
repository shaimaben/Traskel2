<?php

namespace App\Repository;

use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panier>
 *
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }
    public function findPanierById(int $panierId): ?Panier
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :panierId')
            ->setParameter('panierId', $panierId)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function getProductsByIds(array $produitIds): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id IN (:produitIds)')
            ->setParameter('produitIds', $produitIds);

        return $qb->getQuery()->getResult();
    }
    public function removeProduitIdFromPanier(int $panierId, int $produitId): void
    {
        $entityManager = $this->getEntityManager();
        $panier = $this->find($panierId);

        if ($panier) {
            $produitsIds = $panier->getProduitsId();

            $key = array_search($produitId, $produitsIds);
            if ($key !== false) {
                unset($produitsIds[$key]);
            }

            $panier->setProduitsId($produitsIds);

            $entityManager->flush();
        }
    }
    public function getProduitsIdArrayById(int $panierId): ?array
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $result = $queryBuilder
            ->select('p.produits_id')
            ->where('p.id = :panierId')
            ->setParameter('panierId', $panierId)
            ->getQuery()
            ->getOneOrNullResult();

        if ($result) {
            if (is_array($result['produits_id'])) {
                return $result['produits_id'];
            }

            return explode(',', $result['produits_id'] ?? '');
        }

        return null;
    }

    
//    /**
//     * @return Panier[] Returns an array of Panier objects
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

//    public function findOneBySomeField($value): ?Panier
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
