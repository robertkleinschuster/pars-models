<?php


namespace Pars\Model\Form\Field\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class FormFieldTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('FormFieldType.FormFieldType_Code')->setKey(true);
        $saver->addField('FormFieldType.FormFieldType_Active');
        $saver->addField('FormFieldType.FormFieldType_Order');
        $saver->addField('FormFieldType');
    }

    protected function initValidator()
    {

    }

}
