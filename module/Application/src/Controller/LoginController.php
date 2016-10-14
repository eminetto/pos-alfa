<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        $form = new \Application\Form\Login();
        $view = new ViewModel();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $dadosForm = $form->getData();
                $adapter = $this->getEvent()->getApplication()->getServiceManager()->get(\Application\Factory\DbAdapter::class);
                $auth = new \Application\Service\Auth($adapter, $dadosForm['usuario'], $dadosForm['senha']);
                if ($auth->authenticate()->isValid()) {
                    $sessao = new Container('Auth');
                    $sessao->admin = true;
                    $sessao->identity = $auth->authenticate()->getIdentity();
                    return $this->redirect()->toRoute('beer');
                } else {
                    $errorCode = $auth->authenticate()->getCode();
                    switch ($errorCode) {
                        case \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID:
                            $view->setVariable('error', "A credencial informada não tem validade!");
                            break;
                        case \Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND:
                            $view->setVariable('error', "Não foi encontrado o usuário digitado!");
                            break;
                        case \Zend\Authentication\Result::FAILURE_IDENTITY_AMBIGUOUS:
                            $view->setVariable('error', "Identidade duplicada!");
                            break;
                        default :
                            $view->setVariable('error', "Falha não identificada, entre em contato com o administrado!");
                            break;
                    }
                }
            } else {
                $view->setVariable('error', "Os dados informados não são válidos, verifique e tente novamente!");
            }
        }
        $view->setTerminal(true);
        return $view->setVariable('form', $form);
    }

    public function sairAction() {
        $sessao = new Container;
        $sessao->getManager()->getStorage()->clear();
        return $this->redirect()->toRoute('login');
    }

}
