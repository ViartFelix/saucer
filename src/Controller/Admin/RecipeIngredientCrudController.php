<?php

namespace App\Controller\Admin;

use App\Entity\RecipeIngredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecipeIngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeIngredient::class;
    }

	public function configureFields(string $pageName): iterable
	{
		yield IdField::new('id')->hideOnForm();
		yield IntegerField::new('quantity');
		yield TextField::new('unit');
		yield CollectionField::new('ingredient');
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
