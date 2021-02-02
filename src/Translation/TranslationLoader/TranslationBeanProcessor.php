<?php

namespace Pars\Model\Translation\TranslationLoader;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\TimestampMetaFieldHandler;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class TranslationBeanProcessor
 * @package Pars\Model\Translation\TranslationLoader
 */
class TranslationBeanProcessor extends AbstractBeanProcessor implements ValidationHelperAwareInterface, TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Translation_ID', 'Translation_ID', 'Translation', 'Translation_ID', true);
        $saver->addColumn('Translation_Code', 'Translation_Code', 'Translation', 'Translation_ID');
        $saver->addColumn('Translation_Namespace', 'Translation_Namespace', 'Translation', 'Translation_ID');
        $saver->addColumn('Locale_Code', 'Locale_Code', 'Translation', 'Translation_ID');
        $saver->addColumn('Translation_Text', 'Translation_Text', 'Translation', 'Translation_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Translation', 'Translation_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Translation', 'Translation_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Translation', 'Translation_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Translation', 'Translation_ID');

        parent::__construct($saver);
        $this->addMetaFieldHandler(new TimestampMetaFieldHandler('Timestamp_Edit', 'Timestamp_Create'));
    }

    protected function beforeSave(BeanInterface $bean)
    {
        parent::beforeSave($bean);
        if (!$bean->empty('Translation_Text')) {
            $text = $bean->get('Translation_Text');
            $text = str_replace('[', '{', $text);
            $text = str_replace(']', '}', $text);
            $bean->set('Translation_Text', $text);
        }
    }

    protected function translate(string $code)
    {
        if ($this->hasTranslator()) {
            return $this->getTranslator()->translate($code, 'validation');
        } else {
            return $code;
        }
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('Translation_Code')) {
            $this->getValidationHelper()->addError('Translation_Code', $this->translate('translation.code.empty'));
        }
        if (!$bean->empty('Locale_Code') && !$bean->empty('Translation_Code') && !$bean->empty('Translation_Namespace')) {
            $finder = new TranslationBeanFinder($this->adapter);
            $finder->setLocale_Code($bean->get('Locale_Code'));
            $finder->setTranslation_Code($bean->get('Translation_Code'));
            $finder->setTranslation_Namespace($bean->get('Translation_Namespace'));
            if (!$bean->empty('Translation_ID')) {
                $finder->setTranslation_ID($bean->get('Translation_ID'), true);
            }
            if ($finder->count()) {
                $this->getValidationHelper()->addError('Translation_Code', $this->translate('translation.code.unique'));
            }
        }
        return !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return !$bean->empty('Translation_ID');
    }
}
