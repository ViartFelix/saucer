<?php

namespace App\DataFixtures;

use App\Entity\Ingredients;
use App\Entity\Ustensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
	private array $ingredients = [
		"Flour",
		"Vinegar",
		"Cooking oil",
		"Paprika",
		"Egg",
		"Rice",
		"Salt",
		"Canned tomatoes",
		"Onions",
		"Sugar",
		"Milk",
		"Mustard",
		"Butter",
		"Capers",
		"Cheese",
		"Chicken",
		"Beef",
		"Pork",
		"Garlic",
		"Ginger",
		"Mayonnaise"
	];

    public function load(ObjectManager $manager): void
    {
		foreach ($this->getfixturesIngredient() as $ingredientFix)
		{
			$ingredient = new Ingredients();
			$ingredient->setNom($ingredientFix);

			$manager->persist($ingredient);
		}

		$manager->flush();
    }

	public function getfixturesIngredient(?string $key = null)
	{
		if(!empty($key))
		{
			return $this->ingredients[$key];
		}
		else {
			return $this->ingredients;
		}
	}
}
