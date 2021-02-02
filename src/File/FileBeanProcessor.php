<?php

namespace Pars\Model\File;

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
use Pars\Model\File\Directory\FileDirectoryBeanFinder;
use Pars\Model\File\Type\FileTypeBeanFinder;
use Psr\Http\Message\UploadedFileInterface;


/**
 * Class FileBeanProcessor
 * @package Pars\Model\File
 */
class FileBeanProcessor extends AbstractBeanProcessor implements
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    private $adapter;

    protected string $folder = 'u';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('File_ID', 'File_ID', 'File', 'File_ID', true);
        $saver->addColumn('File_Name', 'File_Name', 'File', 'File_ID');
        $saver->addColumn('File_Code', 'File_Code', 'File', 'File_ID');
        $saver->addColumn('FileType_Code', 'FileType_Code', 'File', 'File_ID');
        $saver->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'File', 'File_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'File', 'File_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'File', 'File_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'File', 'File_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'File', 'File_ID');
        parent::__construct($saver);
    }

    /**
     * @param BeanInterface $bean
     * @throws \Niceshops\Bean\Type\Base\BeanException
     */
    protected function beforeSave(BeanInterface $bean)
    {
        $filesystem = $this->getFilesystem($bean);
        $slugify = new Slugify();
        if ($bean->empty('File_Code')) {
            $bean->set('File_Code', "{$slugify->slugify($bean->get('File_Name'))}.{$bean->get('FileType_Code')}");
        }
        if (!$filesystem->has($bean->get('File_Code')) && !$bean->empty('File_Upload')) {
            $upload = $bean->get('File_Upload');
            if ($upload instanceof UploadedFileInterface) {
                $bean->set('File_Code', rtrim($bean->get('File_Code'), '.' . $bean->get('FileType_Code')));
                $path = $this->getFilePath($bean);
                $upload->moveTo($path);
                /* $mime = $filesystem->getMimetype($path);
                 $finder = new FileTypeBeanFinder($this->adapter);
                 $finder->setFileType_Code($bean->getData('FileType_Code'));
                 if ($finder->find() === 1) {
                     $type = $finder->getBean();
                     if ($type->getData('FileType_Mime') !== $mime) {
                         $filesystem->delete($path);
                         $this->getValidationHelper()->addError('Upload', $this->translate('file.upload.invalid'));
                         throw new \Exception('Invalid file type uploaded.');
                     }
                 }*/
            }
        }
        parent::beforeSave($bean);
    }

    /**
     * @param string $folder
     */
    public function setFolder(string $folder): void
    {
        $this->folder = $folder;
    }

    /**
     * @return int
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function delete(): int
    {
        $beanList = $this->getBeanListForDelete();
        foreach ($beanList as $bean) {
            $filesystem = $this->getFilesystem($bean);
            if ($filesystem->has($bean->get('File_Code'))) {
                $filesystem->delete($bean->get('File_Code'));
            }
        }
        return parent::delete();
    }

    /**
     * @param BeanInterface $bean
     * @return Filesystem
     */
    protected function getFilesystem(BeanInterface $bean): Filesystem
    {
        $filesystemAdapter = new Local($this->getDirectoryPath($bean));
        return new Filesystem($filesystemAdapter);
    }

    /**
     * @param BeanInterface $bean
     * @return string
     * @throws \Niceshops\Bean\Type\Base\BeanException
     */
    protected function getDirectoryPath(BeanInterface $bean)
    {
        $path = implode(DIRECTORY_SEPARATOR, [
            $_SERVER["DOCUMENT_ROOT"], $this->folder
        ]);
        if (!$bean->empty('FileDirectory_ID')) {
            $finder = new FileDirectoryBeanFinder($this->adapter);
            $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'));
            if ($finder->count() === 1) {
                $directory = $finder->getBean();
                $path = implode(DIRECTORY_SEPARATOR, [
                    $_SERVER["DOCUMENT_ROOT"], $this->folder, $directory->get('FileDirectory_Code')
                ]);
            }
        }
        return $path;
    }

    /**
     * @param BeanInterface $bean
     * @return string
     * @throws \Niceshops\Bean\Type\Base\BeanException
     */
    protected function getFilePath(BeanInterface $bean)
    {
        $path = implode(DIRECTORY_SEPARATOR, [
            $_SERVER["DOCUMENT_ROOT"], $this->folder, $bean->get('File_Code')
        ]);
        if (!$bean->empty('FileDirectory_ID')) {
            $finder = new FileDirectoryBeanFinder($this->adapter);
            $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'));
            if ($finder->count() === 1) {
                $directory = $finder->getBean();
                $path = implode(DIRECTORY_SEPARATOR, [
                    $_SERVER["DOCUMENT_ROOT"], $this->folder, $directory->get('FileDirectory_Code'), $bean->get('File_Code') . '.' . $bean->get('FileType_Code')
                ]);
            }
        }
        return $path;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function translate(string $name): string
    {
        return $this->getTranslator()->translate($name, 'validation');
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForSave(BeanInterface $bean): bool
    {

        $clientFileName = null;
        if (!$bean->empty('File_Upload')) {
            $upload = $bean->get('File_Upload');
            if ($upload instanceof UploadedFileInterface) {
                switch ($upload->getError()) {
                    case UPLOAD_ERR_CANT_WRITE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error.cant.write'));
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error.form.size'));
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error.ini.size'));
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error.no.file'));
                        break;
                }
                if ($upload->getError() != UPLOAD_ERR_OK) {
                    $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error'));
                } else {
                    $clientFileName = $upload->getClientFilename();
                }
            } else {
                $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.error'));
            }
        } elseif ($bean->empty('File_ID')) {
            $this->getValidationHelper()->addError('File_Upload', $this->translate('file.upload.empty'));
        }

        if ($bean->empty('File_Name')) {
            if ($clientFileName) {
                $bean->set('File_Name', $clientFileName);
            } else {
                $this->getValidationHelper()->addError('File_Name', $this->translate('file.name.empty'));
            }
        } else {
            $finder = new FileBeanFinder($this->adapter);
            if (!$bean->empty('File_ID')) {
                $finder->setFile_ID($bean->get('File_ID'), true);
            }
            $finder->setFile_Name($bean->get('File_Name'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('File_Name', $this->translate('file.name.unique'));
            }
        }

        if ($bean->empty('File_Code')) {
            if ($clientFileName) {
                $bean->set('File_Code', $clientFileName);
            } else {
                $this->getValidationHelper()->addError('File_Code', $this->translate('file.code.empty'));
            }
        } else {
            $finder = new FileBeanFinder($this->adapter);
            if (!$bean->empty('File_ID')) {
                $finder->setFile_ID($bean->get('File_ID'), true);
            }
            $finder->setFile_Code($bean->get('File_Code'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('File_Code', $this->translate('file.code.unique'));
            }
        }

        if ($bean->empty('FileDirectory_ID')) {
            $this->getValidationHelper()->addError('FileDirectory_ID', $this->translate('filedirectory.code.empty'));
        }
        if ($bean->empty('FileType_Code')) {
            $this->getValidationHelper()->addError('FileType_Code', $this->translate('filetype.code.empty'));
        } else {
            $finder = new FileTypeBeanFinder($this->adapter);
            $finder->setFileType_Code($bean->get('FileType_Code'));
            $finder->setFileType_Active(true);
            if ($finder->count() !== 1) {
                $this->getValidationHelper()->addError('FileType_Code', $this->translate('filetype.code.invalid'));
            }
        }


        return !$this->getValidationHelper()->hasError();
    }
}
