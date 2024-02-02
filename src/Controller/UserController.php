<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Parts\UserEditType;
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
	{}

	#[Route('/user/{id}', name: 'app_user')]
    public function index(User $user): Response
    {
		$favs = $user->getFavoriteRecipes();
		$recipes = $user->getRecipes();

		$currUser = $this->getUser();

		if($currUser !== null)
		{
			//Si le compte que l'utilisateur veut voir est le même que son propre compte.
			if($currUser->getId() === $user->getId())
			{
				return $this->redirectToRoute('app_profile');
			}
		}

        return $this->render('user/profile.twig', [
			"user" => $user,
			"favorites" => $favs,
			"recipes" => $recipes,
			"isEditable" => false,
        ]);
    }

	#[Route('/profile', name: 'app_profile')]
	public function profile(): Response
	{
		$user = $this->getUser();
		$favs = $user->getFavoriteRecipes();
		$recipes = $user->getRecipes();

		return $this->render('user/profile.twig',[
			"user" => $user,
			"favorites" => $favs,
			"recipes" => $recipes,
			"isEditable" => true,
		]);
	}

	#[Route('/profile/edit', name: 'app_profile_edit')]
	public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
	{
		$user = $this->getUser();

		$form = $this->createForm(UserEditType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user->setUpdatedAt(new DateTimeImmutable());

			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('app_profile');
		}

		$id = $user->getUserIdentifier();

		return $this->render('user/profile_edit.twig', [
			"form" => $form,
			"user" => $id,
		]);
	}

	//TODO: faire les erreurs dans les champs des formulaires
	//TODO: faire un check du régex dans les formulaires d'emails
}
