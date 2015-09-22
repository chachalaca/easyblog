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


class Comment extends BaseEntity
{

	/** @return int */
	public function getID()
	{
		return $this->record->id;
	}


	/** @return string */
	public function getMessage()
	{
		return $this->record->message;
	}


	/**
	 * @param  string $message
	 * @return Comment
	 */
	public function setMessage($message)
	{
		$this->record->message = (string) $message;
		return $this;
	}


    /** @return User */
    public function getUser()
	{
        return new User($this->record->user);
    }


	/** @return \DateTime */
	public function getCreatedAt()
	{
		return $this->record->created_at;
	}


	/**
	 * @param  \DateTime $date
	 * @return Category
	 */
	public function setCreatedAt(\DateTime $date)
	{
		$this->record->created_at = $date;
		return $this;
	}

}
