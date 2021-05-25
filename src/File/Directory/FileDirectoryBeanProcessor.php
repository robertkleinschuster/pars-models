<?php

namespace Pars\Model\File\Directory;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;
use Pars\Model\File\FileBeanFinder;

/**
 * Class FileDirectoryBeanProcessor
 * @package Pars\Model\File\Directory
 */
class FileDirectoryBeanProcessor extends AbstractBeanProcessor implements
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    protected $adapter;

    /**
     * FileDirectoryBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'FileDirectory', 'FileDirectory_ID', true);
        $saver->addColumn('FileDirectory_Code', 'FileDirectory_Code', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('FileDirectory_Name', 'FileDirectory_Name', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('FileDirectory_Active', 'FileDirectory_Active', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'FileDirectory', 'FileDirectory_ID');

        parent::__construct($saver);
    }

    protected function translate(string $name): string
    {
        return $this->getTranslator()->translate($name, 'validation');
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->isset('FileDirectory_Code')) {
            $bean->set('FileDirectory_Code', StringHelper::slugify($bean->get('FileDirectory_Code')));
        }
        parent::beforeSave($bean);
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('FileDirectory_Name')) {
            $this->getValidationHelper()->addError('FileDirectory_Name', $this->translate('filedirectory.name.empty'));
        } else {
            $finder = new FileDirectoryBeanFinder($this->adapter);
            if (!$bean->empty('FileDirectory_ID')) {
                $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'), true);
            }
            $finder->setFileDirectory_Name($bean->get('FileDirectory_Name'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()
                    ->addError('FileDirectory_Name', $this->translate('filedirectory.name.unique'));
            }
        }

        if ($bean->empty('FileDirectory_Code')) {
            $this->getValidationHelper()->addError('FileDirectory_Code', $this->translate('filedirectory.code.empty'));
        } else {
            $finder = new FileDirectoryBeanFinder($this->adapter);
            if (!$bean->empty('FileDirectory_ID')) {
                $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'), true);
            }
            $finder->setFileDirectory_Name($bean->get('FileDirectory_Code'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()
                    ->addError('FileDirectory_Code', $this->translate('filedirectory.code.unique'));
            }
        }

        return !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        $finder = new FileBeanFinder($this->adapter);
        $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'));
        if ($finder->count()) {
            $this->getValidationHelper()->addError('General', $this->translate('filedirectory.not_empty'));
        }
        return !$this->getValidationHelper()->hasError();
    }
}
