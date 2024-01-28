<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

	/*
    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'ingredients')]
    private Collection $idRecipe;
	*/

    #[ORM\OneToOne(mappedBy: 'ingredient', cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY')]
    private ?RecipeIngredient $recipeIngredient = null;

    public function __construct()
    {
        //$this->idRecipe = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Recipe>
     */
    public function getIdRecipe(): Collection
    {
        return $this->idRecipe;
    }

	/* TODO: les ingredients sont rajoutés même s'ils existent.
    public function addIdRecipe(Recipe $idRecipe): static
    {
        if (!$this->idRecipe->contains($idRecipe)) {
            $this->idRecipe->add($idRecipe);
        }

        return $this;
    }

    public function removeIdRecipe(Recipe $idRecipe): static
    {
        $this->idRecipe->removeElement($idRecipe);

        return $this;
    }

    public function getQuantiy(): ?int
    {
        return $this->quantiy;
    }

    public function setQuantiy(?int $quantiy): static
    {
        $this->quantiy = $quantiy;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
	*/

    public function getRecipeIngredient(): ?RecipeIngredient
    {
        return $this->recipeIngredient;
    }

    public function setRecipeIngredient(?RecipeIngredient $recipeIngredient): static
    {
        // unset the owning side of the relation if necessary
        if ($recipeIngredient === null && $this->recipeIngredient !== null) {
            $this->recipeIngredient->setIngredient(null);
        }

        // set the owning side of the relation if necessary
        if ($recipeIngredient !== null && $recipeIngredient->getIngredient() !== $this) {
            $recipeIngredient->setIngredient($this);
        }

        $this->recipeIngredient = $recipeIngredient;

        return $this;
    }
}
