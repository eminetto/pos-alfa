<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        $form = new \Application\Form\Login();
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
                    throw new \Exception("Acesso negado", 404);
                }
            } else {
                throw new \Exception("Formulário inválido!", 404);
            }
        }
        return $view = new ViewModel(['form'=>$form]);
//        return $view->setTerminal(true);
    }

    public function sairAction() {
        $sessao = new Container;
        $sessao->getManager()->getStorage()->clear();
        return $this->redirect()->toRoute('login');
    }

}
