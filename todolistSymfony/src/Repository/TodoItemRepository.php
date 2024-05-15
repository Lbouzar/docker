<?php

namespace App\Repository;

use App\Entity\TodoItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TodoItem>
 *
 * @method TodoItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoItem[]    findAll()
 * @method TodoItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoItem::class);
    }
    public function findDueItems(\dateTimeInterface $dueDate): array 
    {
        return $this->createQueryBuilder('t')
        ->where('t.dueDate <= :dueDate')
        ->andWhere('t.isCompleted = :isCompleted')
        ->setParameter('dueDate', $dueDate)
        ->setParameter('isCompleted',false)
        ->orderBy('t.dueDate','ASC')
        ->getQuery()
        ->getResult();
    }
    public function findByCompletedStatus(bool $isCompleted): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.isCompleted = :isCompleted')
            ->setParameter('isCompleted',$isCompleted)
            ->getQuery()
            ->getResult();
    }
    //search functionality by keyword
    public function searchByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.title LIKE :keyword OR t.description LIKE :keyword')
            ->setParameter('keyword','%'.$keyword.'%')
            ->getQuery()
            ->getResult();
    }


    
//    /**
//     * @return TodoItem[] Returns an array of TodoItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TodoItem
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
