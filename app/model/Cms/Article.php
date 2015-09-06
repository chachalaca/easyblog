<?php

namespace App\Model\Cms;
use App\Model\BaseModel;

/**
 * Trida zajistuje operace nad clanky
 *
 * @author Samuel Butta
 *
 */
class Article extends BaseModel
{

    /**
     * Returns article
     * @return mixed
     */
    public function getArticles() {
        return $this->db->table('article')->order('created_at DESC');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getArticle($id) {
        return $this->db->table('article')->get($id);
    }

    /**
     * @param int $count
     * @return \Nette\Database\Table\Selection
     */
    public function getLastArticles($count) {
        return $this->db->table('article')->order('created_at DESC')->limit($count);
    }


    /**
     * @param $slug
     * @return mixed
     */
    public function getIdBySlug($slug) {
        return $this->db->table('article')->where('slug', $slug)->fetch()->id;
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public function getArticlesByCategory($categoryId) {
        $articles = array();

        $category = $this->db->table('category')->get($categoryId);
        foreach ($category->related('article_category') as $articleCategory) {
            $articles[] = $articleCategory->article;
        }
        return $articles;
    }

}
