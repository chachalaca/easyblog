<?php

namespace App\FrontModule\Presenters;

use Nette\Application\UI\Form;
use App\Model\UserManager;
use \Nette\Security\AuthenticationException;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{

    /** @var UserManager */
    private $userManager;


    public function __construct(UserManager $userManager)
	{
        $this->userManager = $userManager;
    }


    protected function createComponentSignInForm()
	{
        $form = new Form();
        $form->addText('username', 'Jméno:');
        $form->addPassword('password', 'Name');
        $form->addSubmit('btnLogin', 'Přihlásit');
        $form->addCheckbox('remember');

        $form->onSuccess[] = $this->signInFormSucceeded;
        return $form;
    }


    public function signInFormSucceeded(Form $form, $values)
	{
        try {
            $this->user->login($values->username, $values->password);

            if ($values->remember) {
                $this->user->setExpiration('7 day', FALSE);
            } else {
                $this->user->setExpiration('30 minutes', TRUE);
            }

            $this->flashMessage('Úspěšné přihlášení', 'success');
            $this->redirect('Homepage:');

        } catch (AuthenticationException $ex) {
            $this->flashMessage('Špatné jméno nebo heslo.', 'error');
        }
    }


    protected function createComponentRegisterForm()
	{
        $form = new Form();
        $form->addText('email', 'E-mail:')
            ->setRequired();
        $form->addPassword('password', 'Helso:')
            ->setRequired();
        $form->addPassword('password2', 'Heslo znovu:')
            ->setRequired();
        $form->addText('name', 'Celé jméno:')
            ->setRequired();
        $form->addCheckbox('terms');
        $form->addSubmit('btnRegister', 'Registrovat');

        $form->onSuccess[] = $this->registerFormSucceeded;
        return $form;
    }


    public function registerFormSucceeded(Form $form)
	{
        $values = $form->getValues();

        if ($values->password == $values->password2) {
            $userExist = $this->userManager->add($values->name, $values->password);

            if ($userExist) {
                $this->redirect('Sign:in');

            } else {
                $this->flashMessage('Uživatel už existuje', 'error');
            }

        } else {
            $this->flashMessage('Hesla se neshodují', 'error');
        }
    }


    public function createComponentResetForm()
	{
        $form = new Form();
        $form->addText('email');
        $form->addSubmit('btnReset', 'Odeslat');

        $form->onSuccess[] = array($this, 'resetFormSubmit');

        return $form;
    }


    public function resetFormSubmit(Form $form, $values)
	{
        $success = $this->userManager->resetPassword($values->email);

        if ($success) {
            $this->flashMessage('Nové heslo bylo zasláno na e-mail', 'success');

        } else {
            $this->flashMessage('E-mail neexistuje', 'error');
        }

        $this->redirect('this');
    }


    public function actionOut()
	{
        $this->getUser()->logout();
        $this->flashMessage('Úspěšné odhlásení', 'success');
        $this->redirect('in');
    }

}
