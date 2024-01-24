<?php

namespace App\Entity;

use App\Repository\InstructionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\ManyToOne(inversedBy: 'instructions')]
    private ?Recipe $id_recipe = null;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function setIdRecipe(?Recipe $id_recipe): static
    {
        $this->id_recipe = $id_recipe;

        return $this;
    }
}
