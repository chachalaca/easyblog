<?php

namespace App\FrontModule\Presenters;

use App\Model\Repository\ArticleRepository;
use Nette;


class HomepagePresenter extends BasePresenter
{

    public function actionDefault()
	{
        $this->redirect('Article:');
    }

}
