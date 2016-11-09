<?php

namespace AppBundle\Security\AdminUser;

use AppBundle\Exception\AccountDeletedException;
use AppBundle\Entity\AdminUser as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user is deleted, show a generic Account Not Found message.
        if (!$user->isEnabled()) {
            throw new \Exception('...');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user account is expired, the user may be notified
        //if ($user->isExpired()) {
        //    throw new AccountExpiredException('...');
        //}
    }
}