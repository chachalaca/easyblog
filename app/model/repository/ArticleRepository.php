<?php
/**
 * Created by PhpStorm.
 * User: samik
 * Date: 21.9.15
 * Time: 1:21
 */

namespace App\Model\Repository;


use YetORM\Repository;
use \App\Model\Entity\Article;

/**
 * @table article
 * @entity Article
 */
class ArticleRepository extends Repository
{
    /** @return EntityCollection of Article */
    public function getArticles() {
        return $this->findAll();
    }

    /**
     * @param int $id
     * @return \App\Model\Entity\Article
     */
    public function getArticle($id) {
        return $this->getByID($id);
    }

    /**
     * @param array() $values
     * @return \Nette\Database\Table\Selection of new record
     */
    public function addArticle($values) {
        return $this->database->table('article')->insert($values);
    }


    /**
     * @param int $articleId
     * @param array() $values
     * @return \Nette\Database\Table\Selection
     */
    public function updateArticle($articleId, $values) {
        $article = $this->database->table('article')->wherePrimary($articleId);
        $article->update($values);

        return $article;
    }

}