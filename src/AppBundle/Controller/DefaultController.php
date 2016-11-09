<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * @Route("/panel", name="panel")
     */
    public function panelAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:panel.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
   
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');
        
        return $this->render('AppBundle:Security:login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }
    
    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        // will never be executed
        return new Response();
    }
}
