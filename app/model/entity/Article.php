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
 * @property-read int $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property \DateTime $created_at
 */
class Article extends BaseEntity
{
    public function getAllCategories() {
        $selection = $this->record->related('article_in_category');
        return new EntityCollection($selection, '\App\Model\Entity\Category', 'category');
    }

    public function getAllComments() {
        $selection = $this->record->related('comment', 'article_id');
        return new EntityCollection($selection, '\App\Model\Entity\Comment');
    }




}