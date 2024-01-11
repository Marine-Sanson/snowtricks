<?php

/**
 * CommentMapper File Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Mapper;

use App\Entity\User;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Model\HomeMedia;

/**
 * CommentMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class CommentMapper
{
    /**
     * Summary of getCommentEntity
     *
     * @param string $content content
     * @param int    $trickId trickId
     * @param int    $userId  userId
     * 
     * @return Comment
     */
    public function getCommentEntity(string $content, Trick $trick, User $user): Comment
    {
        $date = new \DateTimeImmutable();

        $comment = (new Comment())
            ->setContent($content)
            ->setTrick($trick)
            ->setAuthor($user)
            ->setCreatedAt($date)
            ->setUpdatedAt($date);
        
            return $comment;
    }

    /**
     * Summary of getTrickGroupModel
     *
     * @param Media $media Media
     *
     * @return HomeMedia
     */
    public function getMediaModel(Media $media): HomeMedia
    {
        return new HomeMedia($media->getId(), $media->getTypeMedia()->getId(), $media->getName());
    }

}
