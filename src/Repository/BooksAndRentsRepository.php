<?php

namespace App\Repository;

use App\Entity\BooksAndRents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BooksAndRents>
 *
 * @method BooksAndRents|null find($id, $lockMode = null, $lockVersion = null)
 * @method BooksAndRents|null findOneBy(array $criteria, array $orderBy = null)
 * @method BooksAndRents[]    findAll()
 * @method BooksAndRents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksAndRentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BooksAndRents::class);
    }

    public function add(BooksAndRents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BooksAndRents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    

    public function findByISBN($ISBN){
        $conn = $this->getEntityManager()->getConnection();
        $sql="SELECT 
        bar.id,
        bar.user_id,
        bar.isbn,
        bar.author,
        bar.publisher,
        bar.title,
        bar.sub_title,
        bar.category,
        bar.description,
        bar.cover,
        bar.language,
        bar.relase_date,
        bar.rent_started_at,
        bar.rent_ended_at,
        bar.is_rented,
        bar.rent_price,
        u.id as user_id ,
        u.last_name,
        u.first_name,
        u.email,
        u.is_actif,
        u.is_deleted,
        u.created_at,
        u.updated_at 
        FROM books_and_rents bar LEFT JOIN 'users' u ON bar.user_id=u.id WHERE bar.isbn LIKE '%".$ISBN."%';" ;       $books=$conn->fetchAllAssociative($sql);
        return $books;
            }
        
//    /**
//     * @return BooksAndRents[] Returns an array of BooksAndRents objects
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

//    public function findOneBySomeField($value): ?BooksAndRents
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
