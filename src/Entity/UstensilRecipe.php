<?php

namespace App\Entity;

use App\Repository\UstensilRecipeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UstensilRecipeRepository::class)]
class UstensilRecipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ustensilRecipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $id_recipe = null;

    #[ORM\OneToOne(inversedBy: 'id_ustensil', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ustensil $id_ustensil = null;

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

    public function getIdUstensil(): ?Ustensil
    {
        return $this->id_ustensil;
    }

    public function setIdUstensil(Ustensil $id_ustensil): static
    {
        $this->id_ustensil = $id_ustensil;

        return $this;
    }
}
