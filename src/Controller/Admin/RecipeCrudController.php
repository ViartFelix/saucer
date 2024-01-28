<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Entity\Ustensil;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id')->hideOnForm(),
			TextField::new('title'),
			TextareaField::new('description'),
			IntegerField::new("prep_time"),
			IntegerField::new("cook_time"),
			ImageField::new('thumbnail')
				->setBasePath('uploads/recipes')
				->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
				->setUploadDir('public/uploads/recipes'),
		];
	}

	public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		if (!$entityInstance instanceof Recipe) return;
		parent::persistEntity($entityManager, $entityInstance);
	}

	public function updateEntity(EntityManagerInterface $entityManager, $entityInstance):void
	{
		if (!$entityInstance instanceof Recipe) return;
		parent::persistEntity($entityManager, $entityInstance);
	}

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
