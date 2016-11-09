<?php

namespace AppBundle\Security\AdminUser;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class AdminUserAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @param UserPasswordEncoderInterface $encoder
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UserPasswordEncoderInterface $encoder, UrlGeneratorInterface $urlGenerator)
    {
        $this->encoder = $encoder;
        $this->urlGenerator = $urlGenerator;
    }
    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('panel_login');
    }
    /**
     * {@inheritdoc}
     */
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->urlGenerator->generate('panel_homepage');
    }
    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != $this->urlGenerator->generate('panel_login_check')) {
            return;
        }
        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
        
        return [
            'username' => $username,
            'password' => $password
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];
        
        return $userProvider->loadUserByUsername($username);
    }
    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        
        if (!$this->encoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException();
        }
        
        /*$currentHour = date('G');
        if ($currentHour < 14 || $currentHour > 16) {
            throw new \Exception(
                'You can only log in between 14 and 16!',
                100
            );
        }*/
        
        return true;
    }
}