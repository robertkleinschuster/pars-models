<?php

namespace Pars\Model\Frontend\Statistic;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class FrontendStatisticProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('FrontendStatistic.FrontendStatistic_ID')->setKey(true);
        $saver->addField('FrontendStatistic.FrontendStatistic_Group');
        $saver->addField('FrontendStatistic.FrontendStatistic_Reference');
    }

    protected function initValidator()
    {

    }

}
