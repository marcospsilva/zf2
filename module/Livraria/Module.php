<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Livraria;

use Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\ModuleManager\ModuleManager;



use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use Livraria\Model\CategoriaTable;
use Livraria\Service\Categoria as CategoriaService;
use Livraria\Service\Livro as LivroService;
use Livraria\Service\User as UserService;
use LivrariaAdmin\Form\Livro as LivroFrm;
use Livraria\Auth\Adapter as AuthAdapter;

class Module implements \Zend\ModuleManager\Feature\ServiceProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /*
     * Configura os Namespaces da Aplicação
     */

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ . "Admin" => __DIR__ . '/src/' . __NAMESPACE__ . "Admin",
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init(ModuleManager $moduleManager) {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach("LivrariaAdmin", 'dispatch', function($e) {
            $auth = new AuthenticationService;
            $auth->setStorage(new SessionStorage("LivrariaAdmin"));
            $controller = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
       
            if (!$auth->hasIdentity() and ( $matchedRoute == "livraria-admin" or $matchedRoute == "livraria-admin-interna")) {
                return $controller->redirect()->toRoute('livraria-admin-auth');
            }
        }, 99);
    }

    /*
     * Carrega todas configurações de serviço, para quando chamamos o serviço
     * de onde a gente quizer da aplicação
     */

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Livraria\Model\CategoriaService' => function ($service) {
                    $dbAdapter = $service->get('Zend\Db\Adapter\Adapter');
                    $categoriaTable = new CategoriaTable($dbAdapter);
                    $categoriaservice = new Model\CategoriaService($categoriaTable);
                    return $categoriaservice;
                },
                'Livraria\Service\Categoria' => function($service) {
                    return new CategoriaService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Livraria\Service\Livro' => function($service) {
                    return new LivroService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Livraria\Service\User' => function($service) {
                    return new UserService($service->get('Doctrine\ORM\EntityManager'));
                },
                'LivrariaAdmin\Form\Livro' => function($service) {
                    $em = $service->get('Doctrine\ORM\EntityManager');
                    $repository = $em->getRepository('Livraria\Entity\Categoria');
                    $categorias = $repository->fetchPairs();
                    return new LivroFrm(null, $categorias);
                },
                'Livraria\Auth\Adapter' => function($service) {
                    return new AuthAdapter($service->get('Doctrine\ORM\EntityManager'));
                },
        ));
    }

    public function getViewHelperConfig() {
        return array(
            'invokables' => array(
                'UserIdentity' => 'Livraria\View\Helper\UserIdentity'
            )
        );
    }

}
