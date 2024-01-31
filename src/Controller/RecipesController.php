<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Ustensil;
use App\Form\IngredientType;
use App\Form\InstructionType;
use App\Form\RecipesFiltersType;
use App\Form\UstensilType;

use App\Repository\UserRepository;
use App\Service\FileHandler;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;

use DateTimeImmutable;

class RecipesController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipes')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
		$repo = $entityManager->getRepository(Recipe::class);

		$form = $this->createForm(RecipesFiltersType::class, null,[
			'attr' => [
				'class' => 'form-container',
				'id' => 'form-filters'
			]
		]);
		$form->handleRequest($request);

		$filteredRecipes = $repo->findAll();

		if($form->isSubmitted() && $form->isValid())
		{
			$criteria = $form->getData();
			$filteredRecipes = $repo->findSearch($criteria);
		}

        return $this->render('recipes/index.twig', [
			"recipes" => $filteredRecipes,
			"form" => $form
		]);
    }

	//Créer une recette
	#[Route('/recipes/new', name: 'app_recipes_create')]
	public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
	{
		$recipe = new Recipe();

		$form = $this->createFormBuilder($recipe)
			->add('title', TextType::class, [
				"required" => false,
			])
			->add('instructions', CollectionType::class, [
				"entry_type" => InstructionType::class,
				'entry_options' => [
					"required" => false,
				],
				'prototype' => true,
				"allow_add" => true,
				'by_reference' => false,
			])
			->add('ustensils', null, [
				'choice_label' => 'nom',
			])
			->add('recipeIngredients', CollectionType::class, [
				"entry_type" => IngredientType::class,
				'entry_options' => [
					"required" => false,
				],
				'prototype' => true,
				"allow_add" => true,
				'by_reference' => false,
				"mapped" => false,
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
			//$ustensiles = $recipe->getUstensils();

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

				//$instruction set thumbnail
				$recipe->setThumbnail($newFilename);
			}

			foreach ($recipe->getInstructions() as $key => $instruction) {
				$file = $form->get('instructions')[$key]->get('mediaFile')->getData();

				if(isset($file))
				{
					$uploader = new FileHandler($slugger);
					$name = $uploader->handleFile($file);
					$instruction->setMedia($name);
				}
			}

			// Ajouter les ustensiles à la recette à partir des données du formulaire
			foreach ($form->get('ustensils')->getData() as $ustensil) {
				$recipe->addUstensil($ustensil);
			}


			foreach($form->get('recipeIngredients')->getData() as $key => $recipeIngredient) {
				$ingredient = $form->get('recipeIngredients')[$key]->get('ingredient')->getData() ?? null;
				$recipeIngredient->setIngredient($ingredient);
				$recipe->addRecipeIngredient($recipeIngredient);
			}

			$entityManager->persist($recipe);

			try {
				$entityManager->flush();
			} catch (\Exception $e) {
				// Gérer les exceptions ou les erreurs ici
				dd($e->getMessage());
				// Arrêtez l'exécution ou redirigez vers une page d'erreur
			}

			return $this->redirectToRoute('app_home');
		}

		return $this->render('recipes/create.twig', [
			"form" => $form,
		]);
	}

	//Voir une seule recette
	#[Route('/recipes/{id}', name: 'app_recipes_single')]
	public function single(Recipe $recipe, int $id, EntityManagerInterface $entityManager): Response
	{
		$hasFavorite = null;

		if($this->getUser() !== null)
		{
			$hasFavorite = (bool)$this->getUser()->getFavoriteRecipes()->contains($recipe);
			$hasFavorite = $hasFavorite ? 'true' : 'false';
		}

		$repo = $entityManager->getRepository(Recipe::class);
		$nbrLikes = $repo->getNbrLikes($id);

		//Single recette
		return $this->render('recipes/single.twig', [
			"recipe" => $recipe,
			"favorite" => $hasFavorite,
			"likes" => $nbrLikes,
		]);
	}

	#[Route('/recipes/{id}/favorite', name: 'app_recipes_favorite')]
	public function toggleFav(Recipe $recipe, int $id, EntityManagerInterface $entityManager)//: RedirectResponse
	{
		$user = $this->getUser();
		$hasFavorite = $user->getFavoriteRecipes()->contains($recipe);

		if($hasFavorite) {
			$this->getUser()->removeFavoriteRecipe($recipe);
		}
		else {
			$this->getUser()->addFavoriteRecipe($recipe);
		}

		$entityManager->persist($user);

		try {
			$entityManager->flush();
		} catch (\Exception $e) {
			dd($e->getMessage());
		}

		return $this->redirectToRoute("app_recipes_single",[
			"id" => $id
		]);
	}
}