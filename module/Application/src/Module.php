<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

class Module
{
    const VERSION = '3.0.2dev';

    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getServiceManager()->get('EventManager');
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, [$this, 'mvcPreDispatch'], 100);
        $eventManager->getSharedManager()->attach(
            'Zend\Db\TableGateway\AbstractTableGateway',
            \Zend\Db\TableGateway\Feature\EventFeatureEventsInterface::EVENT_POST_INSERT,
            [$this, 'postInsert'],
            100);

    }

    public function postInsert($event)
    {
        var_dump($event);
        exit;
    }

    public function mvcPreDispatch($event)
    {
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');
        // if ($controllerName == 'Application\Controller\BeerController' && $actionName == 'delete') {
        //     $authService = $event->getApplication()->getServiceManager()->get('Application\Service\Auth');
        //     if (! $authService->isAuthorized()) {
        //         $redirect = $event->getTarget()->redirect();
        //         $redirect->toUrl('/');
        //     }
        // }
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
