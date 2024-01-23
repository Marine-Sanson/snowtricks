<?php

/**
 * TricksVoter File Doc Comment
 *
 * @category Voter
 * @package  App\Security\Voter
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Trick;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * TricksVoter Class Doc Comment
 *
 * @category Voter
 * @package  App\Security\Voter
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TricksVoter extends Voter
{

    /**
     * Summary of EDIT
     *
     * const string
     */
    const EDIT = 'TRICKS_EDIT';

    /**
     * Summary of DELETE
     *
     * const string
     */
    const DELETE = 'TRICKS_DELETE';


    /**
     * Summary of function __construct
     *
     * @param Security $security Security
     */
    public function __construct(private Security $security)
    {

    }


    /**
     * Summary of authenticate
     *
     * @param string $attribute Attribute
     * @param mixed  $trick     trick
     *
     * @return bool
     */
    protected function supports(string $attribute, mixed $trick): bool
    {

        // If the attribute isn't one we support, return false.
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        // Only vote on `Post` objects.
        if (!$trick instanceof Trick) {
            return false;
        }

        return true;

    }


    /**
     * Summary of authenticate
     *
     * @param string         $attribute Attribute
     * @param mixed          $trick     trick
     * @param TokenInterface $token     Token
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $trick, TokenInterface $token): bool
    {

        $user = $token->getUser();

        if (!$user instanceof User) {
            // The user must be logged in; if not, deny access.
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($trick, $user),
            self::DELETE => $this->canDelete($trick, $user),
            default => throw new \LogicException('This code should not be reached!')
        };

    }


    /**
     * Summary of canEdit
     *
     * @param Trick $trick Trick
     * @param User  $user  User
     *
     * @return bool
     */
    private function canEdit(Trick $trick, User $user): bool
    {

        return $this->security->isGranted('ROLE_ADMIN');

    }


    /**
     * Summary of canDelete
     *
     * @param Trick $trick Trick
     * @param User  $user  User
     *
     * @return bool
     */
    private function canDelete(Trick $trick, User $user): bool
    {

        return $this->security->isGranted('ROLE_ADMIN');

    }


}
