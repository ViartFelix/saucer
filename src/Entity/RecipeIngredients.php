<?php

namespace App\Entity;

use App\Repository\RecipeIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngredientsRepository::class)]
class RecipeIngredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $id_recipe = null;

    #[ORM\OneToOne(inversedBy: 'recipeIngredients', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredients $id_ingredient = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column]
    private ?int $unit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRecipe(): ?Recipe
    {
        return $this->id_recipe;
    }

    public function setIdRecipe(?Recipe $id_recipe): static
    {
        $this->id_recipe = $id_recipe;

        return $this;
    }

    public function getIdIngredient(): ?Ingredients
    {
        return $this->id_ingredient;
    }

    public function setIdIngredient(Ingredients $id_ingredient): static
    {
        $this->id_ingredient = $id_ingredient;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?int
    {
        return $this->unit;
    }

    public function setUnit(int $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
