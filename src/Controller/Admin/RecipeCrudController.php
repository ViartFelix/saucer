<?php

namespace App\Controller\Admin;

use App\Entity\Ingredients;
use App\Entity\Instructions;
use App\Entity\Recipe;
use App\Entity\Ustensil;
use App\Form\IngredientType;
use App\Form\InstructionType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileHandler;

class RecipeCrudController extends AbstractCrudController
{

	public function __construct(
		private FileHandler $fileHandler
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

		yield AssociationField::new('recipeIngredients')
			->setFormTypeOption('choice_label', 'ingredient.nom')
			->setFormTypeOption('by_reference', false)
			//->setCrudController(IngredientsCrudController::class)
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
		$this->persistUpdate($entityManager, $entityInstance);
	}

	public function updateEntity(EntityManagerInterface $entityManager, $entityInstance):void
	{
		$this->persistUpdate($entityManager, $entityInstance);
	}

	private function persistUpdate(EntityManagerInterface $entityManager, $entityInstance): void
	{
		if($entityInstance instanceof Recipe) {
			foreach ($entityInstance->getInstructions() as $instruction) {
				$name = $this->fileHandler->handleFile($instruction->getMediaFile());

				if(!empty($name)) $instruction->setMedia($name);
				else $instruction->setMedia(null);
			}
		}

		$entityInstance->setUpdatedAt(DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d')));
		parent::persistEntity($entityManager, $entityInstance);
	}
}
