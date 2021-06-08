<?php

namespace Pars\Model\File\Directory;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;
use Pars\Model\File\FileBeanFinder;

/**
 * Class FileDirectoryBeanProcessor
 * @package Pars\Model\File\Directory
 */
class FileDirectoryBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'FileDirectory', 'FileDirectory_ID', true);
        $saver->addColumn('FileDirectory_Code', 'FileDirectory_Code', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('FileDirectory_Name', 'FileDirectory_Name', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('FileDirectory_Active', 'FileDirectory_Active', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'FileDirectory', 'FileDirectory_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'FileDirectory', 'FileDirectory_ID');

    }

    protected function initValidator()
    {

    }




    public function translate(string $code, array $vars = [], ?string $namespace = null): string
    {
        return $this->translateValidation($code);
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
            $finder = new FileDirectoryBeanFinder($this->getDatabaseAdapter());
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
            $finder = new FileDirectoryBeanFinder($this->getDatabaseAdapter());
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
        $finder = new FileBeanFinder($this->getDatabaseAdapter());
        $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'));
        if ($finder->count()) {
            $this->getValidationHelper()->addError('General', $this->translate('filedirectory.not_empty'));
        }
        return !$this->getValidationHelper()->hasError();
    }
}
