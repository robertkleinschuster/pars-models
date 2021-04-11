<?php

declare(strict_types=1);

namespace Pars\Model;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\I18n\Translator\Loader\RemoteLoaderInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;
use Pars\Core\Config\ConfigFinderInterface;
use Pars\Core\Deployment\UpdaterInterface;
use Pars\Core\Localization\LocaleFinderInterface;
use Pars\Core\Translation\MissingTranslationSaverInterface;
use Pars\Model\Authentication\User\UserBeanFactory;
use Pars\Model\Authentication\UserRepositoryFactory;
use Pars\Model\Config\ConfigBeanFinder;
use Pars\Model\Localization\Locale\LocaleBeanFinder;
use Pars\Model\Translation\MissingTranslationSaver;
use Pars\Model\Translation\TranslationLoader\TranslationBeanFinder;
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
                RemoteLoaderInterface::class => TranslationBeanFinder::class
            ],
            'invokables' => [
            ],
            'factories' => [
                UpdaterInterface::class => \Pars\Model\Updater\ParsUpdaterFactory::class,
                UserRepositoryInterface::class => UserRepositoryFactory::class,
                UserInterface::class => UserBeanFactory::class,
                LocaleFinderInterface::class => function (ContainerInterface $container) {
                    return new LocaleBeanFinder($container->get(AdapterInterface::class));
                },
                TranslationBeanFinder::class => function (ContainerInterface $container) {
                    return new TranslationBeanFinder($container->get(AdapterInterface::class));
                },
                ConfigFinderInterface::class => function (ContainerInterface $container) {
                    return new ConfigBeanFinder($container->get(AdapterInterface::class));
                },
                MissingTranslationSaverInterface::class => function (ContainerInterface $container) {
                    return new MissingTranslationSaver($container->get(AdapterInterface::class));
                },
            ],
            'delegators' => [
            ],
        ];
    }

}
