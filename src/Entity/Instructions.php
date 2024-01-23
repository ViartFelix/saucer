<?php

namespace App\Entity;

use App\Repository\InstructionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructionsRepository::class)]
class Instructions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'instructions', targetEntity: Recipe::class)]
    private Collection $idRecipe;

    public function __construct()
    {
        $this->idRecipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $idRecipe->setInstructions($this);
        }

        return $this;
    }

    public function removeIdRecipe(Recipe $idRecipe): static
    {
        if ($this->idRecipe->removeElement($idRecipe)) {
            // set the owning side to null (unless already changed)
            if ($idRecipe->getInstructions() === $this) {
                $idRecipe->setInstructions(null);
            }
        }

        return $this;
    }
}
