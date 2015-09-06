<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\Cms\Article;


class HomepagePresenter extends Nette\Application\UI\Presenter
{


    /** @var  Article */
    private $article;

    /**
     * HomepagePresenter constructor.
     * @param Article $article
     */
    public function __construct(Article $article) {
        parent::__construct();
        $this->article = $article;
    }


    public function renderDefault() {


    }

}
