<?php

namespace App\Security\Voter;

use App\Entity\Animal;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AnimalVoter extends Voter
{
    // Here, modify and archive $animal (App\Entity\Animal)
    protected function supports($attribute, $subject)
    {
    
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, ['update', 'archive', 'read'])) {
            return false;
        }

        // only vote on `Animal` objects
        if (!$subject instanceof Animal) {
            return false;
        }
        
        // In other cases, the Voter must vote
        return true;

    
    }

    /**
     * @param string $attribute The attribute/action to perform.
     * @param mixed $subject The entity on which the action is performed
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // The connected User(who is in a Token object, see the Profiler)
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'read':
                // Is the user the author of the animal file?
                return $user === $subject->getUser();
                break;
            case 'update':
                // Is the user the author of the animal file?
                return $user === $subject->getUser();
                break;

            case 'archive':
                // Is the user the author of the animal file?
                return $user === $subject->getUser();
                break;
        }

        // Otherwise, we vote no
        return false;
    }
}
