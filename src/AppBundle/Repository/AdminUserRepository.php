<?php

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\AdminUser;

class AdminUserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function create($username, $password, $email, $inactive) {
        $user = new AdminUser();
        $user->setUserName($username);
        $user->setEmail($email);
        $user->setIsActive($inactive);                 
        $encoder = $this->container->get('security.password_encoder');
        $pwd = $encoder->encodePassword($user, $password);
        $user->setPassword($pwd);

        $this->_em->persist($user);
        $this->_em->flush();
       
        return $user;
    }
}