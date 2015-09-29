<?php


namespace App\Model\Repository;

use Nette\Database\Context;
use YetORM\Entity;
use YetORM\Repository;
use \App\Model\Entity\Article;


/**
 * @table article
 * @entity Article
 */
class ArticleRepository extends Repository
{
    protected $articlesInCategories;

    public function __construct(
        Context $database,
        ArticleInCategoryRepository $articlesInCategories
    ) {
        $this->articlesInCategories = $articlesInCategories;

        parent::__construct($database);
    }

    public function setArticleCategories($article, array $categories) {
        $articleId = ! $article instanceof Entity ?: $article->getId();
        $categoryIds = ! $categories[0] instanceof Entity ? $categories : array_map(function($c){return $c->getId();}, $categories);

        foreach($this->articlesInCategories->findBy(array('article_id' => $articleId)) as $bind) {
            $this->articlesInCategories->delete($bind);
        }

        foreach($categoryIds as $categoryId) {
            $bind = $this->articlesInCategories->createEntity();

            $bind->setArticleId($articleId);
            $bind->setCategoryId($categoryId);

            $this->articlesInCategories->persist($bind);
        }
    }
}
