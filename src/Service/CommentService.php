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
     * @param CommentRepository      $commentRepository MediaRepository
     */
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly TrickRepository $trickRepository,
        private readonly UserRepository $userRepository,
        private readonly CommentMapper $commentMapper,
        private readonly MediaRepository $mediaRepository,
        ) { }

        public function getTrickComments(TrickDetails $trick): array
        {
            $comments = $this->commentRepository->findByTrick($trick->getId());
            foreach($comments as $comment){
                if($comment->getAuthor()->getAvatar() === null){
                    $comment->getAuthor()->setAvatar($this->mediaRepository->find(10));
                }
            }
            return $comments;
        }

        public function addComment(string $content, int $trickId, int $userId): void
        {
            $trick = $this->trickRepository->findOneById($trickId);
            $user = $this->userRepository->findOneById($userId);
            $newComment = $this->commentMapper->getCommentEntity($content, $trick, $user);
            $this->commentRepository->saveComment($newComment);
        }

}
