<?php


namespace Pars\Model\Form\Field;


use Pars\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;

class FormFieldBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('FormField.FormField_ID')->setKey(true);
        $saver->addField('FormField.Form_ID');
        $saver->addField('FormField.FormFieldType_Code');
        $saver->addField('FormField.FormField_Required');
        $saver->addField('FormField.FormField_Order');
        $saver->addField('FormField.FormField_Code');
        $saver->addDefaultFields('FormField');
    }

    protected function initValidator()
    {
        $this->addSaveValidatorFunction('validateFormField_Code');
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->isset('FormField_Code')) {
            $bean->set('FormField_Code', StringHelper::slugify($bean->get('FormField_Code')));
        }
        parent::beforeSave($bean);
    }

    protected function initMetaFieldHandler()
    {
        parent::initMetaFieldHandler();
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new FormFieldBeanFinder($this->getDatabaseAdapter()), 'FormField_Order', 'Form_ID'));
    }


    /**
     * @param FormFieldBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateFormField_Code(FormFieldBean $bean)
    {
        $result = false;
        if ($bean->empty('FormField_Code')) {
            $this->getValidationHelper()->addError('FormField_Code', $this->translateValidation('formfield.code.empty'));
        } else {
            $finder = new FormFieldBeanFinder($this->getDatabaseAdapter());
            if (!$bean->empty('FormField_ID')) {
                $finder->excludeValue('FormField_ID', $bean->get('FormField_ID'));
            }
            $finder->filterValue('FormField_Code', $bean->get('FormField_Code'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('FormField_Code', $this->translateValidation('formfield.code.unique'));
            } else {
                $result = true;
            }
        }
        return $result;
    }

}
