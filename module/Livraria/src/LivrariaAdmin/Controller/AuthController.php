<?php

namespace LivrariaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use LivrariaAdmin\Form\Login as LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class AuthController extends AbstractActionController {

    public function indexAction() {

        $form = new LoginForm;
        $error = false;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $request->getPost()->toArray();

                $auth = new AuthenticationService;

                $sessionStorage = new SessionStorage("LivrariaAdmin");
                
          
                $auth->setStorage($sessionStorage);

                $authAdapter = $this->getServiceLocator()->get('Livraria\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);
             
               
              
                // var_dump($data['nome']);
                if ($result->isValid()) {
                    $sessionStorage->write($auth->getIdentity()['user'], null);
                   return $this->redirect()->toRoute("livraria-admin", array('controller' => 'categorias'));
                } else
                    $error = true;
            }
        }

        return new ViewModel(array('form' => $form, 'error' => $error));
    }

    public function logoutAction() {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage('LivrariaAdmin'));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('livraria-admin-auth');
    }

}
