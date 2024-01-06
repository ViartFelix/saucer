<?php

namespace App\Entity;

use App\Repository\UstensilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UstensilRepository::class)]
class Ustensil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToOne(mappedBy: 'id', cascade: ['persist', 'remove'])]
    private ?UstensilRecipe $ustensilRecipe = null;

    #[ORM\OneToOne(mappedBy: 'id_ustensil', cascade: ['persist', 'remove'])]
    private ?UstensilRecipe $id_ustensil = null;

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

    public function getUstensilRecipe(): ?UstensilRecipe
    {
        return $this->ustensilRecipe;
    }

    public function setUstensilRecipe(UstensilRecipe $ustensilRecipe): static
    {
        // set the owning side of the relation if necessary
        if ($ustensilRecipe->getId() !== $this) {
            $ustensilRecipe->setId($this);
        }

        $this->ustensilRecipe = $ustensilRecipe;

        return $this;
    }

    public function getIdUstensil(): ?UstensilRecipe
    {
        return $this->id_ustensil;
    }

    public function setIdUstensil(UstensilRecipe $id_ustensil): static
    {
        // set the owning side of the relation if necessary
        if ($id_ustensil->getIdUstensil() !== $this) {
            $id_ustensil->setIdUstensil($this);
        }

        $this->id_ustensil = $id_ustensil;

        return $this;
    }
}
