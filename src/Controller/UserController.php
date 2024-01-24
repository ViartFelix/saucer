<?php

namespace App\Controller;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
	public function profile(): Response
	{
		return $this->render('user/profile.twig');
	}

	#[Route('/profile/edit', name: 'app_profile_edit')]
	public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
	{
		$user = $this->getUser();

		$form = $this->createFormBuilder($user)
			->add('nom', TextType::class, [
				"required" => false,
			])
			->add('prenom', TextType::class, [
				"required" => false,
			])
			->add('envoyer', SubmitType::class)
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$now = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));

			$user->setUpdatedAt($now);

			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('app_profile');
		}

		return $this->render('user/profile_edit.twig', [
			"form" => $form,
		]);
	}
}
