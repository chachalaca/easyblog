<?php

namespace App\FrontModule\Presenters;

use App\Model\Repository\ArticleRepository;
use Nette;
use Nette\Application\UI\Form;


class ArticlePresenter extends BasePresenter
{


    /** @var  ArticleRepository */
    private $articleRepository;

    /** @var  int */
    private $articleId;


    public function __construct(ArticleRepository $articleRepository) {
        parent::__construct();
        $this->articleRepository = $articleRepository;
    }


    public function actionDefault($articleId = NULL) {
        $this->articleId = $articleId;


        $article = $this->articleRepository->getArticle($articleId);

        if($articleId != NULL) {
            $this->authorize();
            $this->checkRecord($article);
            $this['articleForm']->setDefaults($article->toArray());
        }

        $this->template->articles = $this->articleRepository->getArticles();
    }

    public function actionDetail($articleId) {

        $article = $this->articleRepository->getArticle($articleId);
        $this->checkRecord($article);

        $articleCategories = $article->getAllCategories();
        $articleComments = $article->getAllComments();

        $this->template->article = $article;
        $this->template->articleCategories = $articleCategories;
        $this->template->articleComments = $articleComments;
    }

    protected function createComponentArticleForm() {
        $form = new Form();
        $form->addText('title', 'Titulek');
        $form->addTextArea('content', 'Obsah:');

        $form->addSubmit('send', 'Send');
        $form->onSuccess[] = array($this, 'submitArticleForm');

        return $form;
    }

    public function submitArticleForm(Form $form) {
        $values = $form->getValues();

        //new record
        if($this->articleId == NULL) {
            $this->articleRepository->addArticle($values);
        } else { //edit
            $this->articleRepository->updateArticle($this->articleId, $values);
        }
    }


    private function authorize() {
        if(!$this->user->isInRole('admin')) {
            $this->redirect('Homepage:default');
        }
    }

}
