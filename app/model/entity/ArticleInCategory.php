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


class ArticleInCategory extends BaseEntity
{

    /** @return int */
    public function getID()
    {
        return $this->record->id;
    }


    public function getArticleId() {
        return $this->record->article_id;
    }


    public function setArticleId($articleId) {
        $this->record->article_id = $articleId;
        return $this;
    }

    public function getCategoryId() {
        return $this->record->article_id;
    }


    public function setCategoryId($categoryId) {
        $this->record->category_id = $categoryId;
        return $this;
    }


}
