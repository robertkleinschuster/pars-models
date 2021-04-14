<?php


namespace Pars\Model\Task\Log;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class TaskLogBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('TaskLog.TaskLog_ID')->setKey(true);
        $saver->addField('TaskLog.TaskLog_Message');
        $saver->addField('TaskLog.TaskLog_Text');
        $saver->addDefaultFields('TaskLog');
    }

    protected function initValidator()
    {

    }

}
