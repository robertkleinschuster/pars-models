<?php


namespace Pars\Model\Updater;


use Pars\Core\Deployment\UpdaterInterface;
use Psr\Container\ContainerInterface;

class ParsUpdaterFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdaterInterface
     */
    public function __invoke(ContainerInterface $container): UpdaterInterface
    {
        return new ParsUpdater($container);
    }
}
