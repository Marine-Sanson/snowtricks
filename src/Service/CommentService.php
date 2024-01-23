<?php

/**
 * CommentService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use App\Model\TrickDetails;
use App\Mapper\CommentMapper;
use App\Repository\UserRepository;
use App\Repository\MediaRepository;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * CommentService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class CommentService
{


    /**
     * Summary of function __construct
     *
     * @param CommentRepository $commentRepository MediaRepository
     * @param TrickRepository   $trickRepository   TrickRepository
     * @param UserRepository    $userRepository    UserRepository
     * @param CommentMapper     $commentMapper     CommentMapper
     * @param MediaRepository   $mediaRepository   MediaRepository
     */
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly TrickRepository $trickRepository,
        private readonly UserRepository $userRepository,
        private readonly CommentMapper $commentMapper,
        private readonly MediaRepository $mediaRepository,
    ) {

    }


    /**
     * Summary of function getPaginatedTrickComments
     *
     * @param TrickDetails $trick TrickDetails
     * @param int $page page
     * @param int $limit limit
     *
     * @return array
     */
    public function getPaginatedTrickComments(TrickDetails $trick, int $page, int $limit): array
    {

        $data = $this->commentRepository->findCommentsPaginatedByTrick($trick->getId(), $page, $limit);

        if ($data !== []) {
            foreach ($data['comments'] as $comment) {
                if ($comment->getAuthor()->getAvatar() === null) {
                    $comment->getAuthor()->setAvatar($this->mediaRepository->findOneByName('avatar_default.webp'));
                }
            }
        }

        return $data;

    }


    /**
     * Summary of function addComment
     *
     * @param string $content content
     * @param int    $trickId trickId
     * @param int    $userId  userId
     *
     * @return void
     */
    public function addComment(string $content, int $trickId, int $userId): void
    {

        $trick = $this->trickRepository->findOneById($trickId);
        $user = $this->userRepository->findOneById($userId);
        $newComment = $this->commentMapper->getCommentEntity($content, $trick, $user);
        $this->commentRepository->saveComment($newComment);

    }


}
