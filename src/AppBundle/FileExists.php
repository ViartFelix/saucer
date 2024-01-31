<?php

namespace App\AppBundle;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FileExists extends AbstractExtension
{

	private readonly string $photo_recipes;



	public function __construct(
		private Filesystem $fs
	){
		$this->photo_recipes = './uploads/recipes/';
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('file_exists', [$this, 'file_exists']),
		];
	}

	public function file_exists(?string $filePath): bool
	{
		$exists = false;

		try {
			if(isset($filePath))
			{
				if(
					!$this->fs->exists($filePath) &&
					!$this->fs->exists($this->getPhotoRecipes() . $filePath)
				) {}
				else {
					$exists = true;
				}
			}
		} catch (\Exception $e) {
		} finally {
			return $exists;
		}
	}

	public function getPhotoRecipes(): string
	{
		return $this->photo_recipes;
	}
}