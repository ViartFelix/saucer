<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
	/**
	 * @param ObjectManager $manager
	 * @return void
	 */
    public function load(ObjectManager $manager): void
    {}

	/**
	 * @return array
	 */
	public function getDependencies(): array
	{
		return array(
			UserFixtures::class,
			UstensilFixtures::class,
			IngredientFixtures::class,
		);
	}
}
