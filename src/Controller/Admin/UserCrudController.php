<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Ustensil;

use Doctrine\ORM\EntityManagerInterface;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

	private function getRoles(): array
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
		yield IdField::new('id')->hideOnForm();
		yield TextField::new('email');
		yield TextField::new('nom');
		yield TextField::new('prenom');

		yield ChoiceField::new('roles')
			->setChoices($this->getRoles())
			->allowMultipleChoices();

		yield TextField::new('password')
			->setFormType(PasswordType::class);
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
