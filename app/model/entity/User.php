<?php

/**
 * Created by PhpStorm.
 * User: samik
 * Date: 21.9.15
 * Time: 1:16
 */

namespace App\Model\Entity;

use App\Model\Entities\BaseEntity;
use YetORM\Entity;
use YetORM\EntityCollection;
use Nette\Security\Passwords as NPasswords;


class User extends BaseEntity
{

	/** @return int */
	public function getID()
	{
		return $this->record->id;
	}


	/** @return string */
	public function getUsername()
	{
		return $this->record->username;
	}


	/**
	 * @param  string $username
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->record->username = (string) $username;
		return $this;
	}


	/**
	 * @param  string $password
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->record->password = NPasswords::hash($password);
		return $this;
	}


	/**
	 * @param  string $password
	 * @return bool
	 */
	public function checkPassword($password)
	{
		return NPasswords::verify($password, $this->record->password);
	}


	/** @return string */
	public function getRole()
	{
		return $this->record->role;
	}


	/** @return \Nette\Security\Identity */
	public function getIdentity()
	{
		return new \Nette\Security\Identity($this->getID(), $this->getRole(), [
			'username' => $this->getUsername(),
		]);
	}

}
