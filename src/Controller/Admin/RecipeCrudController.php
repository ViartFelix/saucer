<?php

namespace App\Controller\Admin;


use App\Entity\Recipe;
use App\Form\IngredientType;
use App\Form\InstructionType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Service\FileHandler;

class RecipeCrudController extends AbstractCrudController
{

	public function __construct(
		private readonly FileHandler $fileHandler
	){}

    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

	public function configureFields(string $pageName): iterable
	{
		yield IdField::new('id')->hideOnForm();
		yield TextField::new('title');
		yield TextareaField::new('description');
		yield IntegerField::new("prep_time");
		yield IntegerField::new("cook_time");

		yield ImageField::new('thumbnail')
			->setBasePath('uploads/recipes')
			->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
			->setUploadDir('public/uploads/recipes');

		yield AssociationField::new("ustensils")
			->setFormTypeOption('choice_label', 'nom')
			->setFormTypeOption('by_reference', false)
		;

		yield CollectionField::new('recipeIngredients')
			->setEntryType(IngredientType::class)
			->setFormTypeOptions([
				'mapped' => true
			])
		;
		yield CollectionField::new('instructions')
			->setEntryType(InstructionType::class)
			->setFormTypeOptions([
				'by_reference' => false,
			])
		;
	}

	public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		if(!$entityInstance instanceof Recipe) return;

		$entityInstance->setIdUser($this->getUser());
		$this->handleRelations($entityInstance);

		$now = new DateTimeImmutable();
		$entityInstance->setUpdatedAt($now);
		$entityInstance->setCreatedAt($now);

		parent::persistEntity($entityManager, $entityInstance);
	}

	public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		if(!$entityInstance instanceof Recipe) return;

		$now = new DateTimeImmutable();
		$entityInstance->setUpdatedAt($now);

		$this->handleRelations($entityInstance);

		parent::updateEntity($entityManager, $entityInstance);
	}

	public function handleRelations(&$entityInstance): void
	{
		foreach ($entityInstance->getRecipeIngredients() as $recipeIngredient) {
			$ingredient = $recipeIngredient->getIngredient();
			$recipeIngredient->setIngredient($ingredient);
		}

		foreach ($entityInstance->getInstructions() as $instruction) {
			//S'il y avait un média avant celui mis dans le panel
			if($instruction->getMedia() !== null) {

				$newFile = $instruction->getMediaFile();

				//S'il y a un nouveau média, remplacer l'ancien
				if($newFile !== null)
				{
					$name = $this->fileHandler->handleFile($newFile);
					if(!empty($name)) $instruction->setMedia($name);
					else $instruction->setMedia(null);
				}


			}
			//S'il n'y avait pas de média avant la modification
			else {
				$name = $this->fileHandler->handleFile($instruction->getMediaFile());
				if(!empty($name)) $instruction->setMedia($name);
				else $instruction->setMedia(null);
			}
		}
	}
}
