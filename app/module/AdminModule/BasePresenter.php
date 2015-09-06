<?php

namespace App\AdminModule\Presenters;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

/*    public function startup() {
        parent::startup();
        if (!$this->user->isInRole('admin')) {
            $this->redirect(':Front:Homepage:default');
        }
    }*/
}
