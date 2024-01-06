<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
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

    #[ORM\ManyToOne(inversedBy: 'title')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $prep_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cook_time = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\OneToOne(mappedBy: 'id_recipe', cascade: ['persist', 'remove'])]
    private ?Favorite $favorite = null;

    #[ORM\OneToMany(mappedBy: 'id_recipe', targetEntity: Partition::class, orphanRemoval: true)]
    private Collection $partitions;

    #[ORM\ManyToOne(inversedBy: 'id_recipe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UstensilRecipe $ustensilRecipe = null;

    #[ORM\OneToMany(mappedBy: 'id_recipe', targetEntity: UstensilRecipe::class, orphanRemoval: true)]
    private Collection $ustensilRecipes;

    #[ORM\OneToMany(mappedBy: 'id_recipe', targetEntity: RecipeIngredients::class, orphanRemoval: true)]
    private Collection $recipeIngredients;

    public function __construct()
    {
        $this->partitions = new ArrayCollection();
        $this->ustensilRecipes = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
    }

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

    public function getPrepTime(): ?\DateTimeInterface
    {
        return $this->prep_time;
    }

    public function setPrepTime(?\DateTimeInterface $prep_time): static
    {
        $this->prep_time = $prep_time;

        return $this;
    }

    public function getCookTime(): ?\DateTimeInterface
    {
        return $this->cook_time;
    }

    public function setCookTime(?\DateTimeInterface $cook_time): static
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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getFavorite(): ?Favorite
    {
        return $this->favorite;
    }

    public function setFavorite(?Favorite $favorite): static
    {
        // unset the owning side of the relation if necessary
        if ($favorite === null && $this->favorite !== null) {
            $this->favorite->setIdRecipe(null);
        }

        // set the owning side of the relation if necessary
        if ($favorite !== null && $favorite->getIdRecipe() !== $this) {
            $favorite->setIdRecipe($this);
        }

        $this->favorite = $favorite;

        return $this;
    }

    /**
     * @return Collection<int, Partition>
     */
    public function getPartitions(): Collection
    {
        return $this->partitions;
    }

    public function addPartition(Partition $partition): static
    {
        if (!$this->partitions->contains($partition)) {
            $this->partitions->add($partition);
            $partition->setIdRecipe($this);
        }

        return $this;
    }

    public function removePartition(Partition $partition): static
    {
        if ($this->partitions->removeElement($partition)) {
            // set the owning side to null (unless already changed)
            if ($partition->getIdRecipe() === $this) {
                $partition->setIdRecipe(null);
            }
        }

        return $this;
    }

    public function getUstensilRecipe(): ?UstensilRecipe
    {
        return $this->ustensilRecipe;
    }

    public function setUstensilRecipe(?UstensilRecipe $ustensilRecipe): static
    {
        $this->ustensilRecipe = $ustensilRecipe;

        return $this;
    }

    /**
     * @return Collection<int, UstensilRecipe>
     */
    public function getUstensilRecipes(): Collection
    {
        return $this->ustensilRecipes;
    }

    public function addUstensilRecipe(UstensilRecipe $ustensilRecipe): static
    {
        if (!$this->ustensilRecipes->contains($ustensilRecipe)) {
            $this->ustensilRecipes->add($ustensilRecipe);
            $ustensilRecipe->setIdRecipe($this);
        }

        return $this;
    }

    public function removeUstensilRecipe(UstensilRecipe $ustensilRecipe): static
    {
        if ($this->ustensilRecipes->removeElement($ustensilRecipe)) {
            // set the owning side to null (unless already changed)
            if ($ustensilRecipe->getIdRecipe() === $this) {
                $ustensilRecipe->setIdRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredients>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredients $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setIdRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredients $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getIdRecipe() === $this) {
                $recipeIngredient->setIdRecipe(null);
            }
        }

        return $this;
    }
}
