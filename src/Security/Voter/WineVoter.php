<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Wine;

final class WineVoter extends Voter
{
    public const EDIT = 'WINE_EDIT';
    public const VIEW = 'WINE_VIEW';
    public const DELETE = 'WINE_DELETE';

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Wine;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return true;
                break;

            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return true;
                break;
            case self::DELETE:
                return $this->security->is_granted('ROLE_ADMIN') or $this->security->is_granted('WINE_DELETE');
                break;
        }

        return false;
    }
}
