<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function saveComment(Comment $comment): Comment
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();

        return $comment;
    }

    /**
    * @return array
    */
   public function findCommentsPaginatedByTrick(int $id, int $page, int $limit): array
   {
        $limit = abs($limit);

        $result = [];
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.trick = :id')
            ->setParameter('id', $id)
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
            ->orderBy('c.id', 'DESC');

        $paginator = new Paginator($query);
        $comments = $paginator->getQuery()->getResult();

        if(empty($comments)){
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['comments'] = $comments;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        
        return $result;
   }

//    /**
//     * @return Comment[] Returns an array of Comment objects
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

//    public function findOneBySomeField($value): ?Comment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
