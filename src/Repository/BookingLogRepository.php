<?php

namespace App\Repository;

use App\Entity\BookingLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookingLog>
 *
 * @method BookingLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingLog[]    findAll()
 * @method BookingLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingLog::class);
    }

    public function add(BookingLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BookingLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function checkBooking(int $id, string $date): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.foodtruck_id = :val')
            ->andWhere('week(b.date)=week(:date)')
            ->setParameter('val', $id)
            ->setParameter('date', $date)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return BookingLog[] Returns an array of BookingLog objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BookingLog
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
