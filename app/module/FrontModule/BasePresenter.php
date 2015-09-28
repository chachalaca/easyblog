<?php

namespace App\FrontModule\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	protected function authorize()
	{
		if (!$this->user->isInRole('admin')) {
			$this->redirect('default');
		}
	}

}
