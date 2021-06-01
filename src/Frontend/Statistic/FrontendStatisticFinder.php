<?php
namespace Pars\Model\Frontend\Statistic;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class FrontendStatisticFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FrontendStatisticBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('FrontendStatistic.FrontendStatistic_ID')->setKey(true);
        $loader->addField('FrontendStatistic.FrontendStatistic_Group');
        $loader->addField('FrontendStatistic.FrontendStatistic_Reference');
        $loader->addField('FrontendStatistic.FrontendStatistic_Locale');
        $loader->addField('FrontendStatistic.FrontendStatistic_Data');
    }

}
