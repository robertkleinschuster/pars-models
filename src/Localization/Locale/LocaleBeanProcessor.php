<?php

namespace Pars\Model\Localization\Locale;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\OrderMetaFieldHandlerInterface;
use Niceshops\Bean\Processor\TimestampMetaFieldHandler;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class LocaleBeanProcessor
 * @package Pars\Model\Localization\Locale
 */
class LocaleBeanProcessor extends AbstractBeanProcessor implements ValidationHelperAwareInterface, TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Locale_Code', 'Locale_Code', 'Locale', 'Locale_Code', true);
        $saver->addColumn('Locale_Name', 'Locale_Name', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_UrlCode', 'Locale_UrlCode', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_Active', 'Locale_Active', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_Order', 'Locale_Order', 'Locale', 'Locale_Code');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Locale', 'Locale_Code');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Locale', 'Locale_Code');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Locale', 'Locale_Code');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Locale', 'Locale_Code');
        parent::__construct($saver);
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new LocaleBeanFinder($adapter), 'Locale_Order'));
        $this->addMetaFieldHandler(new TimestampMetaFieldHandler('Timestamp_Edit', 'Timestamp_Create'));
    }


    protected function translate(string $code)
    {
        if ($this->hasTranslator()) {
            return $this->getTranslator()->translate($code, 'validation');
        } else {
            return $code;
        }
    }

    /**
     * @inheritDoc
     */
    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('Locale_Code')) {
            $this->getValidationHelper()->addError('Locale_Code', $this->translate('locale.code.empty'));
        } elseif (!$bean->empty('Locale_Code_New')) {
            $finder = new LocaleBeanFinder($this->adapter);
            $finder->setLocale_Code($bean->get('Locale_Code'));
            if ($finder->count()) {
                $this->getValidationHelper()->addError('Locale_Code', $this->translate('locale.code.unique'));
            }
        }
        if ($bean->empty('Locale_Name')) {
            $this->getValidationHelper()->addError('Locale_Name', $this->translate('locale.name.empty'));
        }
        if ($bean->empty('Locale_UrlCode')) {
            $this->getValidationHelper()->addError('Locale_UrlCode', $this->translate('locale.urlcode.empty'));
        } else {
            $finder = new LocaleBeanFinder($this->adapter);
            $finder->setLocale_Code($bean->get('Locale_Code'), true);
            $finder->setLocale_UrlCode($bean->get('Locale_UrlCode'));
            if ($finder->count()) {
                $this->getValidationHelper()->addError('Locale_UrlCode', $this->translate('locale.urlcode.unique'));
            }
        }
        return !$this->getValidationHelper()->hasError();
    }

    /**
     * @inheritDoc
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        return !$bean->empty('Locale_Code');
    }
}
