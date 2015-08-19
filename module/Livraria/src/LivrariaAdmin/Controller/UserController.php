<?php

namespace LivrariaAdmin\Controller;

use Zend\View\Model\ViewModel;

class UserController extends CrudController {

    public function __construct() {
        $this->entity = "Livraria\Entity\User";
        $this->service = "Livraria\Service\User";
        $this->form = "LivrariaAdmin\Form\User";
        $this->controller = "users";
        $this->route = "livraria-admin";
    }

    public function EditAction() {
        $formulario = new $this->form;

        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute("id", 0));
        //se realmetne nos tivemos um parametro sendo passado
        if ($this->params()->fromRoute("id", 0)) {
            $array = $entity->toArray();
            unset($array["password"]);
            $formulario->setData($array);
        }
        if ($request->isPost()) {
            $formulario->setData($request->getPost());
            if ($formulario->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array("controller" => $this->controller));
            }
        }
        return new ViewModel(array("form" => $formulario));
    }

}
