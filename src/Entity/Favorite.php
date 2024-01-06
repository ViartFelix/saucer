<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?User $id_user = null;

    #[ORM\OneToOne(inversedBy: 'favorite', cascade: ['persist', 'remove'])]
    private ?Recipe $id_recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
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
}
