<?php

/**
 * TypeMediaRepository File Doc Comment
 *
 * @category Repository
 * @package  App\Repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Repository;

use App\Entity\TypeMedia;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * TypeMediaRepository Class Doc Comment
 *
 * @extends ServiceEntityRepository<TypeMedia>
 *
 * @category Repository
 * @package  App\Repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @method TypeMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMedia[]    findAll()
 * @method TypeMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMediaRepository extends ServiceEntityRepository
{
    /**
     * Summary of function __construct
     *
     * @param ManagerRegistry $registry ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeMedia::class);
    }

//    /**
//     * @return TypeMedia[] Returns an array of TypeMedia objects
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

//    public function findOneBySomeField($value): ?TypeMedia
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
