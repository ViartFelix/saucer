<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientsRepository::class)]
class Ingredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToOne(mappedBy: 'id_ingredient', cascade: ['persist', 'remove'])]
    private ?RecipeIngredients $recipeIngredients = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRecipeIngredients(): ?RecipeIngredients
    {
        return $this->recipeIngredients;
    }

    public function setRecipeIngredients(RecipeIngredients $recipeIngredients): static
    {
        // set the owning side of the relation if necessary
        if ($recipeIngredients->getIdIngredient() !== $this) {
            $recipeIngredients->setIdIngredient($this);
        }

        $this->recipeIngredients = $recipeIngredients;

        return $this;
    }
}
