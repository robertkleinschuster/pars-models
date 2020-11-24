<?php

declare(strict_types=1);

namespace Pars\Model;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;
use Mezzio\Session\Cache\CacheSessionPersistence;
use Mezzio\Session\SessionPersistenceInterface;
use Pars\Core\Localization\LocaleFinderInterface;
use Pars\Model\Authentication\User\UserBeanFactory;
use Pars\Model\Authentication\UserRepositoryFactory;
use Pars\Model\Localization\Locale\LocaleBeanFinder;
use Psr\Container\ContainerInterface;

/**
 * The configuration provider for the Base module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'aliases' => [
            ],
            'invokables' => [
            ],
            'factories' => [
                UserRepositoryInterface::class => UserRepositoryFactory::class,
                UserInterface::class => UserBeanFactory::class,
                LocaleFinderInterface::class => function (ContainerInterface $container) {
                    return new LocaleBeanFinder($container->get(AdapterInterface::class));
                }
            ],
            'delegators' => [
            ],
        ];
    }

}
