<?php

namespace App\Controller;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;

class RecipesController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipes')]
    public function index(EntityManagerInterface $entityManager): Response
    {
		//Toutes les recettes
		$repo = $entityManager->getRepository(Recipe::class);
		$allRecipes = $repo->findAll();

        return $this->render('recipes/index.twig', [
			"recipes" => $allRecipes,
		]);
    }
	//Créer une recette
	#[Route('/recipes/new', name: 'app_recipes_create')]
	#[IsGranted('ROLE_USER')]
	public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
	{
		$recipe = new Recipe();

		$form = $this->createFormBuilder($recipe)
			->add('title', TextType::class, [
				"required" => true,
			])
			->add('description', TextareaType::class, [
				"required" => false,
			])
			->add('prep_time', NumberType::class, [
				"label" => "Temps de préparation",
				"required" => true,
			])
			->add('cook_time', NumberType::class, [
				"label" => "Temps de cuisson",
				"required" => true,
			])
			->add('thumbnail', FileType::class, [
				"label" => "Photo",
				"required" => false,
				'mapped' => false,
				'constraints' => [
					new File([
						'maxSize' => '4096k',
						'mimeTypes' => [
							'image/gif',
							'image/jpeg',
							'image/png',
							'image/webp',
						],
						'mimeTypesMessage' => 'SVP téléversez une image valide (.png, .jpg, .jpeg ou .webp) et en-dessous de 4Mo',
					])
				],
			])
			->add('envoyer', SubmitType::class)
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//Set de l'ID user
			$recipe->setIdUser($this->getUser());

			$thumbnail = $form->get('thumbnail')->getData();

			if($thumbnail)
			{
				$ogFileName = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($ogFileName);
				$newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

				//TODO: faire un insert, prendre l'ID, et donner le dir du fichier l'ID, puis le bouger dedans
				$thumbnail->move(
					$this->getParameter("photo_recipes"),
					$newFilename,
				);

				$recipe->setThumbnail($newFilename);
			}

			$entityManager->persist($recipe);
			$entityManager->flush();

			return $this->redirectToRoute('app_home');
		}

		return $this->render('recipes/create.twig', [
			"form" => $form,
		]);
	}

	//Voir une seule recette
	#[Route('/recipes/{id}', name: 'app_recipes_single')]
	public function single(Recipe $recipe): Response
	{
		//Single recette
		return $this->render('recipes/single.twig', [
			"recipe" => $recipe,
		]);
	}
}
