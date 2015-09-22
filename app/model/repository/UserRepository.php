<?php

namespace App\Model\Repository;

use YetORM;
use Model\Entities;
use Nette\Utils\Strings as NStrings;


/**
 * @table  user
 * @entity \App\Model\Entity\User
 */
class UserRepository extends YetORM\Repository
{

	/**
	 * @param  string $username
	 * @return \App\Model\Entity\User|NULL
	 */
	public function getByUsername($username)
	{
		return $this->getBy([
			'username' => $username,
		]);
	}


	/**
	 * @param  \Exception $e
	 * @return void
	 */
	protected function handleException(\Exception $e)
	{
		if ($e instanceof \Nette\Database\UniqueConstraintViolationException) {
			if (NStrings::endsWith($e->getMessage(), ' for key \'username\'')) {
				throw new DuplicateNameException;
			}
		}
	}

}
