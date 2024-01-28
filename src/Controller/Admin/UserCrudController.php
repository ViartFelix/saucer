<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Ustensil;
use App\Form\Type\UserRolesType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

	private function getRoles()
	{
		$choises =  $this->getParameter('security.role_hierarchy.roles');
		$final = [];

		foreach ($choises as $role => $val)
		{
			$final[$role] = $role;
		}

		return $final;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id')->hideOnForm(),
			TextField::new('email'),
			TextField::new('nom'),
			TextField::new('prenom'),
			ChoiceField::new('roles')
				->setChoices($this->getRoles())
				->allowMultipleChoices(),
			TextField::new('password'),
		];
	}

	public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
	{
		if (!$entityInstance instanceof User) return;
		parent::persistEntity($entityManager, $entityInstance);
	}

	public function updateEntity(EntityManagerInterface $entityManager, $entityInstance):void
	{
		if (!$entityInstance instanceof User) return;
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
