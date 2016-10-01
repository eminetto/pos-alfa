<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;

class ServiceAuth
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Application\Factory\DbAdapter');
        $request = $container->get('Request');

        return new \Application\Service\Auth($request, $adapter);
    }
}
