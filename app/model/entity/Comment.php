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


/**
 * Class Comment
 * @package App\Model\Entity
 */
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


	/**
	 * @param User $user
	 * @return $this
	 */
	public function setUser(User $user)
	{
		$this->record->user_id = $user->getID();
		return $this;
	}


	/** @return \DateTime */
	public function getCreatedAt()
	{
		return $this->record->created_at;
	}


	/**
	 * @return Article
	 */
	public function getArticle() {
		return new Article($this->record->article);
	}


	/**
	 * @param Article $article
	 * @return $this
	 */
	public function setArticle(Article $article) {
		$this->record->article_id = $article->getID();
		return $this;
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
