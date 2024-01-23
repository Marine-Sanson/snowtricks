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


    /**
     * Summary of function __construct
     *
     * @param ManagerRegistry $registry ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Comment::class);

    }


    /**
     * Summary of function saveComment
     *
     * @param Comment $comment Comment
     *
     * @return Comment
     */
    public function saveComment(Comment $comment): Comment
    {

        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();

        return $comment;

    }


    /**
     * Summary of function setContent
     *
     * @param int $id    id
     * @param int $page  page
     * @param int $limit limit
     *
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

        if (empty($comments)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['comments'] = $comments;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

        return $result;

    }


}
