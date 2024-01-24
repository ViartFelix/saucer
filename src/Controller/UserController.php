<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{

	public function __construct()
	{

	}

	#[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

	#[Route('/profile', name: 'app_profile')]
	#[IsGranted('ROLE_USER', message: "Don't.")]
	public function profile(): Response
	{
		return $this->render('user/profile.twig');
	}
}
