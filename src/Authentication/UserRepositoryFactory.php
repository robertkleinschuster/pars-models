<?php

namespace Pars\Model\Authentication;

use Laminas\Db\Adapter\AdapterInterface;
use Pars\Core\Database\ParsDatabaseAdapter;
use Pars\Model\Authentication\User\UserBeanFinder;
use Psr\Container\ContainerInterface;

/**
 * Class UserRepositoryFactory
 * @package Pars\Model\Authentication
 */
class UserRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return UserBeanFinder
     */
    public function __invoke(ContainerInterface $container)
    {
        return new UserBeanFinder($container->get(ParsDatabaseAdapter::class));
    }
}
