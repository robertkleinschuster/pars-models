<?php


namespace Pars\Model\Task\Log;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class TaskLogBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new TaskLogBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('TaskLog.TaskLog_ID')->setKey(true);
        $loader->addField('TaskLog.TaskLog_Message');
        $loader->addField('TaskLog.TaskLog_Text');
        $loader->addDefaultFields('TaskLog');
    }

}
