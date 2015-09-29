<?php

namespace App\FrontModule\Presenters;

use App\Model\Entity\Article;
use App\Model\Entity\Comment;
use App\Model\Repository\ArticleInCategoryRepository;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use Nette;
use Nette\Application\UI\Form;


class BlogPresenter extends BasePresenter
{

    /** @var ArticleRepository */
    private $articles;

    /** @var  CommentRepository */
    private $comments;

    /** @var UserRepository */
    private $users;

    /**
     * @var CategoryRepository
     */
    private $categories;


    /** @var \App\Model\Entity\Article */
    private $article = NULL;



    public function __construct(
        ArticleRepository $articles,
        CommentRepository $comments,
        UserRepository $users,
        CategoryRepository $categories,
        ArticleInCategoryRepository $articlesInCategories
    )
    {
        parent::__construct();

        $this->articles = $articles;
        $this->comments = $comments;
        $this->users = $users;
        $this->categories = $categories;
    }

    public function actionDetail($articleId) {
        $article = $this->articles->getBy(array('url' => $articleId));

        if ($article == NULL) {
            $this->error('Page not found');
        }
        if (!$this->user->isInRole('admin') and $article->getStatus() != Article\Status::PUBLISHED) {
            $this->redirect('default');
        }

        $this->article = $article;
    }


    /** @return void */
    public function renderDetail($articleId)
    {
        $article = $this->articles->getByID($this->article->getID());

        $this->template->article = $article;
        $this->template->articleCategories = $article->getAllCategories();
        $this->template->articleComments = $article->getAllComments();
    }



    public function renderDefault()
    {
        $this->template->articles = $this->articles
            ->findBy(
                $this->user->isInRole('admin')
                    ? array('status != ?' => Article\Status::DELETED)
                    : array('status = ?' => Article\Status::PUBLISHED)
            )
            ->orderBy('created_at DESC');
    }


    // NewArticle form

    protected function createComponentNewArticleForm()
    {
        $form = new Form;
        $form->addText('title', 'Nový článek s titulkem: ');
        $form->addSubmit('send', 'Vytvořit');
        $form->onSuccess[] = $this->processNewArticleForm;

        return $form;
    }

    public function processNewArticleForm(Form $form, $values)
    {
        $this->authorize();

        $article = $this->articles->createEntity();

        $url = Nette\Utils\Strings::webalize($values->title);
        while($this->articles->findBy(array('url' => $url))->count() > 0) {
            $url .= '-' . Nette\Utils\Random::generate(3);
        }

        $article->setTitle($values->title);
        $article->setUrl($url);

        $this->articles->persist($article);

        $this->redirect('detail', $article->getUrl());
    }



    // Comment form

    protected function createComponentCommentForm()
    {
        $form = new Form();
        $form->getElementPrototype()->class('ajax');
        $form->addTextArea('message');
        $form->addSubmit('send', 'Send');
        $form->onSuccess[] = $this->processCommentForm;

        return $form;
    }

    public function processCommentForm(Form $form, $values)
    {
        $this->authorize();

        $comment = $this->comments->createEntity();
        $user = $this->users->getByID($this->getUser()->getId());

        $comment->setMessage($values->message);
        $comment->setArticle($this->article);
        $comment->setUser($user);
        $comment->setStatus(Comment\Status::PUBLISHED);

        $this->comments->persist($comment);

        $form->setValues(array('message' => NULL));
        $this->redrawControl('comments');
    }



    // Category form

    public function createComponentCategoryForm() {
        $form = new Form();
        $form->getElementPrototype()->onchange('submit()');
        $form->getElementPrototype()->class('ajax');

        $form->addMultiSelect(
            'categories',
            'Kategorie',
            array_reduce(
                $this->categories->findAll()->toArray(),
                function(&$result, $item){
                    $result[$item->getId()] = $item->getTitle();
                    return $result;
                },
                array()
            )
        )
        ->setDefaultValue(
            array_map(
                function ($c) {return $c->getId();},
                $this->article->getAllCategories()->toArray()
            )
        );
        $form->onSuccess[] = $this->processCategoryForm;
        return $form;
    }

    public function processCategoryForm(Form $form, $values)
    {
        $this->authorize();

        $this->articles->setArticleCategories($this->article, $values->categories);

        $this->redrawControl();
    }


    // EditArticleForm

    public function createComponentEditArticleForm() {
        $form = new Form();
        $form->getElementPrototype()->class('ajax');
        $form->getElementPrototype()->id('areaform');

        $form->addTextArea('text')
            ->setDefaultValue($this->article->getContent())
            ->getControlPrototype()->id('area');
        $form->addSubmit('submit');


        $form->onSuccess[] = $this->processEditArticleForm;
        return $form;
    }


    public function processEditArticleForm(Form $form, $values)
    {
        $this->authorize();

        $this->article->setContent($values->text);
        $this->articles->persist($this->article);

        $this->redrawControl();
    }


    public function handleDeleteArticle($id)
    {
        $this->authorize();

        $article = $this->articles->getByID($id);
        if ($article) {
            $article->setStatus(Article\Status::DELETED);
            $this->articles->persist($article);
        }
        $this->redrawControl();
    }


    public function handlePublishArticle($id, $setPublished = TRUE)
    {
        $this->authorize();
        $article = $this->articles->getByID($id);
        if ($article) {
            $article->setStatus(
                $setPublished ? Article\Status::PUBLISHED : Article\Status::UNPUBLISHED
            );
            $this->articles->persist($article);
        }
        $this->redrawControl();
    }


    public function handleDeleteComment($commentId)
    {
        $this->authorize();
        $comment = $this->comments->getByID($commentId);
        if ($comment) {
            $this->comments->delete($comment);
        }
        $this->redrawControl('comments');
    }




}
