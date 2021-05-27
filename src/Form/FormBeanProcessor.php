<?php


namespace Pars\Model\Form;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;

/**
 * Class FormBeanProcessor
 * @package Pars\Model\Form
 */
class FormBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('Form.Form_ID')->setKey(true);
        $saver->addField('Form.FormType_Code');
        $saver->addField('Form.Form_Code');
        $saver->addField('Form.Form_SendEmail');
        $saver->addField('Form.Form_IndexInfo');
        $saver->addDefaultFields('Form');
    }

    protected function initValidator()
    {
        $this->addSaveValidatorFunction('validateForm_Code');
        $this->addSaveValidatorFunction('validateFormType_Code');
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->isset('Form_Code')) {
            $bean->set('Form_Code', StringHelper::slugify($bean->get('Form_Code')));
        }
        parent::beforeSave($bean);
    }


    /**
     * @param FormBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateFormType_Code(FormBean $bean)
    {
        $result = false;
        if ($bean->empty('FormType_Code')) {
            $this->getValidationHelper()->addError('FormType_Code', $this->translateValidation('formtype.code.empty'));
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * @param FormBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateForm_Code(FormBean $bean)
    {
        $result = false;
        if ($bean->empty('Form_Code')) {
            $this->getValidationHelper()->addError('Form_Code', $this->translateValidation('form.code.empty'));
        } else {
            $finder = new FormBeanFinder($this->getDatabaseAdapter());
            if (!$bean->empty('Form_ID')) {
                $finder->excludeValue('Form_ID', $bean->get('Form_ID'));
            }
            $finder->filterValue('Form_Code', $bean->get('Form_Code'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('Form_Code', $this->translateValidation('form.code.unique'));
            } else {
                $result = true;
            }
        }
        return $result;
    }
}
