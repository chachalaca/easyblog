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


class Article extends BaseEntity
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
     * @return Article
     */
    public function setTitle($title)
    {
        $this->record->title = (string) $title;
        return $this;
    }


    /** @return string */
    public function getContent()
    {
        return $this->record->content;
    }


    /**
     * @param  string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->record->content = (string) $content;
        return $this;
    }


    /** @return string */
    public function getURL()
    {
        return $this->record->url;
    }


    /**
     * @param  string $url
     * @return Article
     */
    public function setURL($url)
    {
        $this->record->url = (string) $url;
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


    /** @return \DateTime */
    public function getCreatedAt()
    {
        return $this->record->created_at;
    }


    /**
     * @param  \DateTime $date
     * @return Article
     */
    public function setCreatedAt(\DateTime $date)
    {
        $this->record->created_at = $date;
        return $this;
    }


    /** @return Category[]|EntityCollection */
    public function getAllCategories()
    {
        $selection = $this->record
            ->related('article_in_category')
            ->where(array('category_id.status' => Category\Status::PUBLISHED));
        return new EntityCollection($selection, Category::class, 'category');
    }


    /** @return Comment[]|EntityCollection */
    public function getAllComments()
    {
        $selection = $this->record
            ->related('comment', 'article_id')
            ->where(array('status' => Comment\Status::PUBLISHED))
            ->order('created_at DESC');
        return new EntityCollection($selection, Comment::class);
    }

}

namespace App\Model\Entity\Article;
class Status {
    const UNPUBLISHED = 0;
    const PUBLISHED = 1;
    const DELETED = 9;
}
