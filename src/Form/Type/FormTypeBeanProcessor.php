<?php


namespace Pars\Model\Form\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class FormTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('FormType.FormType_Code')->setKey(true);
        $saver->addField('FormType.FormType_Active');
        $saver->addField('FormType.FormType_Order');
        $saver->addDefaultFields('FormType');
    }

    protected function initValidator()
    {

    }

}
