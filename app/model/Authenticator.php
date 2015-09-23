<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{

	/** @var Repository\UserRepository */
	private $users;


	public function __construct(Repository\UserRepository $users)
	{
		$this->users = $users;
	}


	/**
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$user = $this->users->getByUsername($username);

		if ($user === NULL) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}

		if (!$user->checkPassword($password)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		return $user->getIdentity();
	}

}
