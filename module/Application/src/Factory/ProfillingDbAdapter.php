<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter as ZendAdapter;

class DbAdapter
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $adapter = new \BjyProfiler\Db\Adapter\ProfilingAdapter($config['db']);
        $adapter->setProfiler(new \BjyProfiler\Db\Profiler\Profiler());
        if (isset($config['db']['options']) && is_array($config['db']['options'])) {
            $options = $config['db']['options'];
        } else {
            $options = [];
        }
        $adapter->injectProfilingStatementPrototype($options);
        $profiler = $adapter->getProfiler()->enable();
        return $adapter;
    }
}
