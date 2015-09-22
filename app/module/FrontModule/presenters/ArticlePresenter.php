<?php

namespace App\FrontModule\Presenters;

use App\Model\Repository\ArticleRepository;
use Nette;
use Nette\Application\UI\Form;


class ArticlePresenter extends BasePresenter
{

    /** @var ArticleRepository */
    private $articles;

	/** @var \App\Model\Entity\Article */
	private $article = NULL;


    public function __construct(ArticleRepository $articles)
	{
        parent::__construct();

        $this->articles = $articles;
    }


    public function actionDefault($articleId = NULL)
	{
        if ($articleId !== NULL) {
            $this->authorize();
			$this->article = $this->articles->getByID($articleId);
            $this->checkRecord($this->article);

            $this['articleForm']->setDefaults([
				'title' => $this->article->getTitle(),
				'content' => $this->article->getContent(),
			]);
        }

        $this->template->articles = $this->articles->findAll();
    }


    public function actionDetail($articleId)
	{
        $this->article = $this->articles->getByID($articleId);
        $this->checkRecord($this->article);
    }


	/** @return void */
	public function renderDetail($articleId)
	{
		$articleCategories = $this->article->getAllCategories();
        $articleComments = $this->article->getAllComments();

        $this->template->article = $this->article;
        $this->template->articleCategories = $articleCategories;
        $this->template->articleComments = $articleComments;
	}


    protected function createComponentArticleForm()
	{
        $form = new Form;
        $form->addText('title', 'Titulek');
        $form->addTextArea('content', 'Obsah:');

        $form->addSubmit('send', 'Send');
        $form->onSuccess[] = $this->processArticleForm;

        return $form;
    }


    public function processArticleForm(Form $form, $values)
	{
		if ($this->article === NULL) {
			$article = $this->articles->createEntity();

		} else {
			$article = $this->article;
		}

		$article->setTitle($values->title);
		$article->setContent($values->content);

		$this->articles->persist($article);
    }


    private function authorize()
	{
        if (!$this->user->isInRole('admin')) {
            $this->redirect('default');
        }
    }

}
