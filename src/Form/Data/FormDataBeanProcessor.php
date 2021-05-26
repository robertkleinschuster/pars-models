<?php


namespace Pars\Model\Form\Data;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class FormDataBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('FormData.FormData_ID')->setKey(true);
        $saver->addField('FormData.Form_ID');
        $saver->addField('FormData.FormData_Data');
        $saver->addDefaultFields('FormData');
    }

    protected function initValidator()
    {

    }

}
