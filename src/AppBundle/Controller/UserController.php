<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserRegistrationType;
use AppBundle\Entity\User;

class UserController extends Controller {

    public function indexAction(Request $request) {
        return $this->render('AppBundle:User:index.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function loginAction() {
        $helper = $this->get('security.authentication_utils');

        return $this->render('AppBundle:User:Security/login.html.twig', [
                    'last_username' => $helper->getLastUsername(),
                    'error' => $helper->getLastAuthenticationError()
        ]);
    }

    public function loginCheckAction() {
        // will never be executed
        return new Response();
    }

    public function registerAction() {
        $helper = $this->get('security.authentication_utils');

        $registration = new User();

        $form = $this->createForm(new UserRegistrationType(), $registration);

        return $this->render('AppBundle:User:Security/register.html.twig', [
                    'email' => '',
                    'form' => $form->createView(),
                    'last_username' => $helper->getLastUsername(),
                    'error' => $helper->getLastAuthenticationError()
        ]);
    }

    public function createAction(Request $req) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserRegistrationType(), new User());
        $form->handleRequest($req);

        $user = new User();
        $user = $form->getData();

        //$user->setCreated(new \DateTime());
        $user->setAvatar('http://www.gravatar.com/avatar/' . md5(trim($req->get('email'))));
        $user->setIsActive(true);

        $pwd = $user->getPassword();
        $encoder = $this->container->get('security.password_encoder');
        $pwd = $encoder->encodePassword($user, $pwd);
        $user->setPassword($pwd);

        $em->persist($user);
        $em->flush();

        $url = $this->generateUrl('user_login');
        return $this->redirect($url);
    }

}
