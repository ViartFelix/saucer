<?php

namespace App\Entity;

use App\Repository\UstensilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'ustensils')]
    private Collection $idRecipe;

    public function __construct()
    {
        $this->idRecipe = new ArrayCollection();
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
}
