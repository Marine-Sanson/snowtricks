<?php

/**
 * MediaRepository File Doc Comment
 *
 * @category Repository
 * @package  App\Repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * MediaRepository Class Doc Comment
 *
 * @extends ServiceEntityRepository<Media>
 *
 * @category Repository
 * @package  App\Repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{


    /**
     * Summary of function __construct
     *
     * @param ManagerRegistry $registry ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Media::class);

    }


    /**
     * Summary of delete
     *
     * @param Media $media Media
     * 
     * @return void
     */
    public function delete(Media $media): void
    {

        $this->getEntityManager()->remove($media);
        $this->getEntityManager()->flush();

    }


    /**
     * Summary of save
     *
     * @param Media $media Media
     * 
     * @return void
     */
    public function save(Media $media): void
    {

        $this->getEntityManager()->persist($media);
        $this->getEntityManager()->flush();

    }

}
