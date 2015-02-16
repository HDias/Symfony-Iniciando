<?php

namespace HD\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Login controller.
 * 
 */
class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login")
     * @Template("UserBundle:Security:login.html.twig")
     */
	public function loginAction()
	{
		$authenticationUtils = $this->get('security.authentication_utils');

		// get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();
	    
		return array(
			'last_username' => $lastUsername,
			'error' 		=> $error
		);
	}

	/**
	 * @Route("/login_check", name="login_check")
     */
	public function loginCheckAction()
	{

	}

	/**
	 * @Route("/logout", name="logout")
     */
	public function logoutAction()
	{

	}
}