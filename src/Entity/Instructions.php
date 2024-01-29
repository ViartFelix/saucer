<?php

namespace App\Entity;

use App\Repository\InstructionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: InstructionsRepository::class)]
class Instructions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'instructions')]
    private ?Recipe $recipe = null;

	#[NoReturn]
	public function __construct()
	{
	}

	public function __toString()
	{
		return $this->content;
	}

    public function getId(): ?int
    {
        return $this->id;
    }

	private ?UploadedFile $mediaFile = null;

	public function setMediaFile(UploadedFile $file = null): void
	{
		$this->mediaFile = $file;


		/*
		if(isset($file))
		{
			$this->setMedia($file);
		}
		else {
			$this->setMedia(null);
		}
		*/

	}

	public function getMediaFile(): ?UploadedFile
	{
		return $this->mediaFile;
	}

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

	public function setRecipe(Recipe $recipe): static
	{
		$this->recipe = $recipe;

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
}
