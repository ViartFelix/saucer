<?php

namespace App\Controller\Admin;

use App\Entity\Ingredients;
use App\Entity\Recipe;
use App\Entity\User;
use App\Entity\Ustensil;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractDashboardController
{
	public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator){}

	#[Route('/admin', name: 'app_admin')]
	public function index(): Response
	{

		return parent::index();
		/*
		$url = $this->adminUrlGenerator
			->setController(IngredientsCrudController::class)
			->generateUrl();

		return $this->redirect($url);
		*/
	}

    #[Route('/admin/ingredients', name: 'app_admin_ingredients')]
    public function admin_ingredients(): Response
    {
		$url = $this->adminUrlGenerator
			->setController(IngredientsCrudController::class)
			->generateUrl();

		return $this->redirect($url);
    }



    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Saucer administration');
    }

    public function configureMenuItems(): iterable
    {
		yield MenuItem::section('Dashboard');
		yield MenuItem::linkToDashboard("Dashboard");

		yield MenuItem::section('Recipes');
		yield MenuItem::linkToCrud('Recipes', 'fa fa-tags', Recipe::class);
		yield MenuItem::linkToCrud('Ingredients', 'fa fa-tags', Ingredients::class);
		yield MenuItem::linkToCrud('Ustensiles', 'fa fa-tags', Ustensil::class);

		yield MenuItem::section('Utilisateurs');
		yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
    }
}
