<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class PanelController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('AppBundle:Panel:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
   
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');
        
        return $this->render('AppBundle:Panel:Security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }
    
    public function loginCheckAction()
    {
        // will never be executed
        return new Response();
    }
}
