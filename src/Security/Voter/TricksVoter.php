<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Trick;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TricksVoter extends Voter
{
    const EDIT = 'TRICKS_EDIT';
    const DELETE = 'TRICKS_DELETE';

    public function __construct(private Security $security) {}

    protected function supports(string $attribute, mixed $trick): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$trick instanceof Trick) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $trick, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN')){
            return true;
        }

        return match($attribute) {
            self::EDIT => $this->canEdit($trick, $user),
            self::DELETE => $this->canDelete($trick, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canEdit(Trick $trick, User $user): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    private function canDelete(Trick $trick, User $user): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

}
