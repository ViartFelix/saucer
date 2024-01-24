<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $prep_time = null;

    #[ORM\Column(nullable: true)]
    private ?int $cook_time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToMany(targetEntity: Ingredients::class, mappedBy: 'idRecipe')]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Ustensil::class, mappedBy: 'idRecipe')]
    private Collection $ustensils;

    #[ORM\ManyToOne(inversedBy: 'idRecipe')]
    private ?Instructions $instructions = null;

    #[ORM\OneToOne(mappedBy: 'idRecipe', cascade: ['persist', 'remove'])]
    private ?Favorites $favorites = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->ustensils = new ArrayCollection();

		$this->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d')));
		$this->setUpdatedAt(DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d')));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrepTime(): ?int
    {
        return $this->prep_time;
    }

    public function setPrepTime(int $prep_time): static
    {
        $this->prep_time = $prep_time;

        return $this;
    }

    public function getCookTime(): ?int
    {
        return $this->cook_time;
    }

    public function setCookTime(?int $cook_time): static
    {
        $this->cook_time = $cook_time;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->addIdRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeIdRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ustensil>
     */
    public function getUstensils(): Collection
    {
        return $this->ustensils;
    }

    public function addUstensil(Ustensil $ustensil): static
    {
        if (!$this->ustensils->contains($ustensil)) {
            $this->ustensils->add($ustensil);
            $ustensil->addIdRecipe($this);
        }

        return $this;
    }

    public function removeUstensil(Ustensil $ustensil): static
    {
        if ($this->ustensils->removeElement($ustensil)) {
            $ustensil->removeIdRecipe($this);
        }

        return $this;
    }

    public function getInstructions(): ?Instructions
    {
        return $this->instructions;
    }

    public function setInstructions(?Instructions $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getFavorites(): ?Favorites
    {
        return $this->favorites;
    }

    public function setFavorites(Favorites $favorites): static
    {
        // set the owning side of the relation if necessary
        if ($favorites->getIdRecipe() !== $this) {
            $favorites->setIdRecipe($this);
        }

        $this->favorites = $favorites;

        return $this;
    }
}
