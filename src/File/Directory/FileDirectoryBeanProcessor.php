<?php

namespace Pars\Model\File\Directory;

use Cocur\Slugify\Slugify;
use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
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

    protected $folder = 'u';

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

    /**
     * @param string $folder
     */
    public function setFolder(string $folder): void
    {
        $this->folder = $folder;
    }


    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        $path = implode(DIRECTORY_SEPARATOR, [
            $_SERVER["DOCUMENT_ROOT"], $this->folder
        ]);
        $filesystemAdapter = new Local($path);
        return new Filesystem($filesystemAdapter);
    }

    protected function beforeSave(BeanInterface $bean)
    {
        parent::beforeSave($bean);
        $filesystem = $this->getFilesystem();
        if ($bean->empty('FileDirectory_Code')) {
            $slugify = new Slugify();
            $bean->set('FileDirectory_Code', $slugify->slugify($bean->get('FileDirectory_Name')));
        }
        if (!$filesystem->has($bean->get('FileDirectory_Code'))) {
            $filesystem->createDir($bean->get('FileDirectory_Code'));
        }
    }

    public function delete(): int
    {
        $filesystem = $this->getFilesystem();
        $beanList = $this->getBeanListForDelete();
        foreach ($beanList as $bean) {
            if ($filesystem->has($bean->get('FileDirectory_Code'))) {
                $filesystem->deleteDir($bean->get('FileDirectory_Code'));
            }
        }
        return parent::delete();
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
