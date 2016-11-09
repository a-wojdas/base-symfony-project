<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserLoginListener
{
    /**
     * @var Session
     */
    private $session;
    
    /**
     * @var Container
     */
    private $container;

    public function setContainer (ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __construct(Session $session, ContainerInterface $container)
    {
        $this->session = $session;
        $this->setContainer($container);
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if (null !== $user->getLocale()) {
            $this->session->set('_locale', $user->getLocale());
        }
        
        $user->setLastLogin(new \DateTime());
        
        $em = $this->container->get('doctrine.orm.entity_manager');        
        $em->persist($user);
        $em->flush();
    }
}