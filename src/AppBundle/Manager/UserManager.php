<?php

namespace AppBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

class UserManager implements ContainerAwareInterface
{    
    /**
     * @var Container
     */
    private $container;
    
    /**
     * @var Container
     */
    private $em;
    
    public function setContainer (ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getEntityManager();
    }
    
    
    public function create($username, $password, $email, $inactive) {
        $user = new User();
        $user->setUserName($username);
        $user->setEmail($email);
        $user->setIsActive($inactive);
        
        $hash = $this->container->get('security.password_encoder')->encodePassword($user, $password);
        $user->setPassword($hash);

        $this->em->persist($user);
        $this->em->flush();
       
        return $user;
    }
    
}