<?php

namespace Pars\Model\Localization\Locale;

use Pars\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Bean\Validator\FieldNotEmptyBeanValidator;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;


/**
 * Class LocaleBeanProcessor
 * @package Pars\Model\Localization\Locale
 */
class LocaleBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('Locale.Locale_Code')->setKey(true);
        $saver->addField('Locale.Locale_UrlCode');
        $saver->addField('Locale.Locale_Domain');
        $saver->addField('Locale.Locale_Name');
        $saver->addField('Locale.Locale_Active');
        $saver->addField('Locale.Locale_Order');
        $saver->addDefaultFields('Locale');
    }

    protected function initMetaFieldHandler()
    {
        parent::initMetaFieldHandler();
        $this->addMetaFieldHandler(
            new OrderMetaFieldHandlerInterface(
                new LocaleBeanFinder($this->getDatabaseAdapter()),
                'Locale_Order'
            )
        );
    }

    protected function initValidator()
    {
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('Locale_Code'));
        $this->addSaveValidatorFunction('validateLocale_Code');
        $this->addSaveValidatorFunction('validateLocale_UrlCode');
        $this->addSaveValidatorFunction('validateLocale_Name');
    }

    /**
     * @param LocaleBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateLocale_Code(LocaleBean $bean): bool
    {
        $result = false;
        if ($bean->empty('Locale_Code')) {
            $this->getValidationHelper()
                ->addError('Locale_Code', $this->translateValidation('locale.code.empty'));
        } elseif (!$bean->empty('Locale_Code_New')) {
            $finder = new LocaleBeanFinder($this->getDatabaseAdapter());
            $finder->filterLocale_Code($bean->get('Locale_Code'));
            if ($finder->count()) {
                $this->getValidationHelper()
                    ->addError('Locale_Code', $this->translateValidation('locale.code.unique'));
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * @param LocaleBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateLocale_UrlCode(LocaleBean $bean): bool
    {
        $result = false;
        if ($bean->empty('Locale_UrlCode')) {
            $this->getValidationHelper()
                ->addError('Locale_UrlCode', $this->translateValidation('locale.urlcode.empty'));
        } else {
            $finder = new LocaleBeanFinder($this->getDatabaseAdapter());
            $finder->filterLocale_Code($bean->get('Locale_Code'), true);
            $finder->filterLocale_UrlCode($bean->get('Locale_UrlCode'));
            if ($finder->count()) {
                $this->getValidationHelper()
                    ->addError('Locale_UrlCode', $this->translateValidation('locale.urlcode.unique'));
            } else {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param LocaleBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateLocale_Name(LocaleBean $bean): bool
    {
        $result = false;
        if ($bean->empty('Locale_Name')) {
            $this->getValidationHelper()
                ->addError('Locale_Name', $this->translateValidation('locale.name.empty'));
        } else {
            $result = true;
        }
        return $result;
    }
}
