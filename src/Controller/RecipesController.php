<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Ustensil;
use App\Form\IngredientType;
use App\Form\InstructionType;
use App\Form\RecipesFiltersType;
use App\Form\RecipeType;
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
use Symfony\Component\Form\FormInterface;
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

	public function __construct(
		private readonly SluggerInterface $slugger
	){}



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

		//Prise de toutes les recettes
		$filteredRecipes = $repo->findAll();

		if($form->isSubmitted() && $form->isValid())
		{
			//Prise des données du formulaire
			$criteria = $form->getData();
			$filteredRecipes = $repo->findSearch($criteria);
		}

        return $this->render('recipes/index.twig', [
			"recipes" => $filteredRecipes,
			"form" => $form
		]);
    }

	#[Route('/recipes/new', name: 'app_recipes_create')]
	public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
	{
		$recipe = new Recipe();

		$form = $this->createForm(RecipeType::class, $recipe);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//Set de l'ID user
			$recipe->setIdUser($this->getUser());

			$thumbnail = $form->get('thumbnail')->getData();

			//si la minitaure est présente dans le formulaire
			if($thumbnail)
			{
				$handler = new FileHandler($slugger);
				$recipe->setThumbnail($handler->handleFile($thumbnail) ?? null);
			}

			$this->handleRelations($form, $recipe);

			try {
				$entityManager->persist($recipe);
				$entityManager->flush();

				return $this->redirectToRoute('app_recipes_single', ["id" => $recipe->getId()]);
			} catch (\Exception $e) {
				return $this->render('recipes/create.twig', [
					"form" => $form,
					"errors" => "An unknown error happened. Please retry in a couple of moments."
				]);
			}
		}

		return $this->render('recipes/create.twig', [
			"form" => $form->createView(),
			"errors" => null,
		]);
	}

	/**
	 * Vas, lors de la création de la recette, essayer d'écrire et de gérer les relations : ustensils, ingredients et instructions
	 * @param FormInterface $form
	 * @param Recipe $recipe
	 * @return void
	 */
	private function handleRelations(FormInterface &$form, Recipe &$recipe): void
	{

		//Rajout des instructions
		foreach ($recipe->getInstructions() as $key => $instruction) {
			$file = $form->get('instructions')[$key]->get('mediaFile')->getData();

			if(isset($file))
			{
				$uploader = new FileHandler($this->getSlugger());
				$instruction->setMedia($uploader->handleFile($file) ?? null);
			}

			$recipe->addInstruction($instruction);
		}

		// Ajouter les ustensiles à la recette à partir des données du formulaire
		foreach ($form->get('ustensils')->getData() as $ustensil) {
			$recipe->addUstensil($ustensil);
		}

		//Idem avec les ingredients
		foreach($form->get('recipeIngredients')->getData() as $key => $recipeIngredient) {
			$ingredient = $form->get('recipeIngredients')[$key]->get('ingredient')->getData() ?? null;

			if(isset($ingredient))
			{
				$recipeIngredient->setIngredient($ingredient);
				$recipe->addRecipeIngredient($recipeIngredient);
			}
		}
	}

	/**
	 * Voir une seule recette
	 * @throws Exception
	 */
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

		$author = $recipe->getIdUser();

		//Single recette
		return $this->render('recipes/single.twig', [
			"recipe" => $recipe,
			"favorite" => $hasFavorite,
			"likes" => $nbrLikes,
			"author" => $author,
		]);
	}

	#[Route('/recipes/{id}/favorite', name: 'app_recipes_favorite')]
	public function toggleFav(Recipe $recipe, int $id, EntityManagerInterface $entityManager): RedirectResponse
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

		$errors = null;

		try {
			$entityManager->flush();
		} catch (\Exception $e) {
			$errors = "An unknown error happened. Please try again in a few moments.";
		}

		return $this->redirectToRoute("app_recipes_single",[
			"id" => $id,
			"errors" => $errors,
		]);
	}

	private function getSlugger(): SluggerInterface
	{
		return $this->slugger;
	}
}