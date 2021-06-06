<?php


namespace Pars\Model\Authentication\ApiKey;

use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class ApiKeyBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('ApiKey_ID')->setTable('ApiKey')->setKey(true);
        $saver->addField('ApiKey_Name')->setTable('ApiKey');
        $saver->addField('ApiKey_Key')->setTable('ApiKey');
        $saver->addField('ApiKey_Host')->setTable('ApiKey');
        $saver->addField('ApiKey_Active')->setTable('ApiKey');
        $saver->addField('Person_ID_Create')->setTable('ApiKey');
        $saver->addField('Person_ID_Edit')->setTable('ApiKey');
        $saver->addField('Timestamp_Create')->setTable('ApiKey');
        $saver->addField('Timestamp_Edit')->setTable('ApiKey');
    }

    protected function initValidator()
    {
    }


}
