<?php


namespace App\Model\Entity;

use App\Model\Entities\BaseEntity;
use YetORM\Entity;


class Category extends BaseEntity
{

	/** @return int */
	public function getID()
	{
		return $this->record->id;
	}


	/** @return string */
	public function getTitle()
	{
		return $this->record->title;
	}


	/**
	 * @param  string $title
	 * @return Category
	 */
	public function setTitle($title)
	{
		$this->record->title = (string) $title;
		return $this;
	}


	/** @return string */
	public function getURL()
	{
		return $this->record->url;
	}


	/**
	 * @param  string $url
	 * @return Category
	 */
	public function setURL($url)
	{
		$this->record->url = (string) $url;
		return $this;
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


    /**
     * @return int
     */
    public function getStatus() {
        return $this->record->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status) {
        $this->record->status = $status;
        return $this;
    }

}


namespace App\Model\Entity\Category;
class Status {
    const UNPUBLISHED = 0;
    const PUBLISHED = 1;
    const DELETED = 9;
}
