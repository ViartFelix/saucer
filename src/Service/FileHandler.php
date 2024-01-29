<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileHandler
{
	public function __construct(
		private readonly SluggerInterface $slugger,
	){}

	public function handleFile($file): string|null
	{
		if($file !== null)
		{
			$ogFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
			$safeFilename = $this->slugger->slug($ogFileName);
			$newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

			$file->move(
				getcwd() . "/uploads/recipes",
				$newFilename,
			);

			return $newFilename;
		}

		return null;
	}
}