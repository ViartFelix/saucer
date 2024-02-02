<?php

namespace App\DataFixtures;

use App\Entity\Ustensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UstensilFixtures extends Fixture
{

	private array $ustensils = [
		"Air frier",
		"Pan",
		"Wooden spoon",
		"Frying pan",
		"Saucepan",
		"Knife",
		"Fork",
		"Measuring cup",
		"Peeler",
		"Whisk",
		"Cutting board",
		"Colander",
		"Bowl",
		"Hoven",
		"Spoon",
	];

    public function load(ObjectManager $manager): void
    {
		foreach ($this->getFixturesUstensils() as $ustensilFix)
		{
			$ustensil = new Ustensil();
			$ustensil->setNom($ustensilFix);

			$manager->persist($ustensil);
		}

		$manager->flush();
    }

	public function getFixturesUstensils(?string $key = null)
	{
		if(!empty($key))
		{
			return $this->ustensils[$key];
		}
		else {
			return $this->ustensils;
		}
	}
}
