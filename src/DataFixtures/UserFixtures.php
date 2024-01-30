<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

	public function __construct(
		private readonly UserPasswordHasherInterface $hasher
	)
	{}

    public function load(ObjectManager $manager): void
    {
		//Utilisateur normal
		$userNorm = new User();

		$userNorm
			->setEmail('user@saucer.fr')
			->setIsVerified(true)
			->setRoles(['ROLE_USER'])
		;

		$plainUserPWD = $this->hasher->hashPassword($userNorm, 'user1234');
		$userNorm
			->setPassword($plainUserPWD, true)
		;

		//Utilisateur admin
		$userAdmin = new User();

		$userAdmin
			->setEmail('admin@saucer.fr')
			->setIsVerified(true)
			->setRoles(['ROLE_ADMIN'])
		;

		$plainAdminPWD = $this->hasher->hashPassword($userAdmin, 'admin1234');
		$userAdmin
			->setPassword($plainAdminPWD, true)
		;

		$manager->persist($userNorm);
		$manager->persist($userAdmin);
        $manager->flush();
    }
}
