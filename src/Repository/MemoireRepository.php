<?php

namespace App\Repository;

use App\Entity\Memoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Memoire>
 *
 * @method Memoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Memoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Memoire[]    findAll()
 * @method Memoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Memoire::class);
    }

    public function add(Memoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Memoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(string $titre): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.titre LIKE :val')
            ->setParameter('val', "%$titre%")
            ->getQuery()
            ->getArrayResult()
        ;
    }

//    /**
//     * @return Memoire[] Returns an array of Memoire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Memoire
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
