<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
	public function checkPreAuth(UserInterface $user): void
	{
		if (!$user instanceof AppUser) {
			return;
		}

		if (!empty($user->getDeletedAt())) {
			// the message passed to this exception is meant to be displayed to the user
			throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
		}
	}

	public function checkPostAuth(UserInterface $user): void
	{
		if (!$user instanceof AppUser) {
			return;
		}

		if(in_array('ROLE_NO_VERIFY', $user->getRoles()) || !$user->isVerified())
		{
			throw new CustomUserMessageAccountStatusException('Please enable your account via the sent email. Verify your spams.');
		}
		else
		{
			$user->setRoles([
				"ROLE_USER"
			]);
		}
	}
}