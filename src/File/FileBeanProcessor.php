<?php

namespace Pars\Model\File;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Filesystem\FilesystemHelper;
use Pars\Helper\String\StringHelper;
use Pars\Model\File\Directory\FileDirectoryBeanFinder;
use Pars\Model\File\Type\FileTypeBeanFinder;
use Pars\Pattern\Exception\CoreException;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class FileBeanProcessor
 * @package Pars\Model\File
 */
class FileBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected ?string $basePath = null;

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('File.File_ID')->setKey(true);
        $saver->addField('File.File_Name');
        $saver->addField('File.File_Code');
        $saver->addField('File.FileType_Code');
        $saver->addField('File.FileDirectory_ID');
        $saver->addDefaultFields('File');
    }

    protected function initValidator()
    {
        $this->addSaveValidatorFunction('validateFile_Upload');
        $this->addSaveValidatorFunction('validateFile_Name');
        $this->addSaveValidatorFunction('validateFileType_Code');
        $this->addSaveValidatorFunction('validateFileDirectory_ID');
    }


    /**
     * @param BeanInterface $bean
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function beforeSave(BeanInterface $bean)
    {
        parent::beforeSave($bean);
        $this->loadFileDirectory_Code($bean);
        $this->handleFile_Code($bean);
        $this->saveFile($bean);
    }

    /**
     * @param FileBean $bean
     * @throws \Pars\Bean\Type\Base\BeanException
     */
    public function handleFile_Code(FileBean $bean)
    {
        if ($bean->empty('File_Code')) {
            $code = $bean->get('File_Name');
        } else {
            $code = $bean->get('File_Code');
        }
        $exp = explode('.', $code, 2);
        if (count($exp) == 2) {
            $code = array_shift($exp);
        }
        if ($code) {
            $bean->set('File_Code', StringHelper::slugify($code));
        }
    }

    /**
     * @param FileBean $bean
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getFilePath(FileBean $bean)
    {
        $basePath = $this->getBasePath();
        return "public/$basePath/" . $bean->path();
    }

    /**
     * @param FileBean $bean
     * @param string $path
     */
    protected function saveFile(FileBean $bean)
    {
        if ($bean->isset('File_Upload')) {
            $upload = $bean->get('File_Upload');
            if ($upload instanceof UploadedFileInterface) {
                if ($upload->getSize()) {
                    $path = $this->getFilePath($bean);
                    FilesystemHelper::createDirectory($path);
                    $upload->moveTo($path);
                }
            }
        }
    }

    /**
     * @param FileBean $bean
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function loadFileDirectory_Code(FileBean $bean)
    {
        if (!$bean->empty('FileDirectory_ID') && $bean->empty('FileDirectory_Code')) {
            $finder = new FileDirectoryBeanFinder($this->getDatabaseAdapter());
            $finder->setFileDirectory_ID($bean->get('FileDirectory_ID'));
            if ($finder->count() === 1) {
                $directory = $finder->getBean();
                $bean->FileDirectory_Code = $directory->FileDirectory_Code;
            }
        }
    }

    /**
     * @param BeanInterface $bean
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function beforeDelete(BeanInterface $bean)
    {
        parent::beforeDelete($bean);
        $this->deleteFile($bean);
    }

    /**
     * @param FileBean $bean
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function deleteFile(FileBean $bean)
    {
        $this->loadFileDirectory_Code($bean);
        $filePath = $this->getFilePath($bean);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    protected function validateFile_Upload(FileBean $bean): bool {
        $result = false;
        if (!$bean->empty('File_Upload')) {
            $upload = $bean->get('File_Upload');
            if ($upload instanceof UploadedFileInterface) {
                switch ($upload->getError()) {
                    case UPLOAD_ERR_OK:
                        $result = true;
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error.cant.write'));
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error.form.size'));
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error.ini.size'));
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error.no.file'));
                        break;
                    default:
                        $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error'));
                }
            } else {
                $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.error'));
            }
        } else if ($bean->empty('File_ID')) {
            $this->getValidationHelper()->addError('File_Upload', $this->translateValidation('file.upload.empty'));
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * @param FileBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    protected function validateFile_Name(FileBean $bean): bool
    {
        $result = false;
        if ($bean->empty('File_Name')) {
            $this->getValidationHelper()->addError('File_Name', $this->translateValidation('file.name.empty'));
        } else {
            $finder = new FileBeanFinder($this->getDatabaseAdapter());
            if (!$bean->empty('File_ID')) {
                $finder->excludeFile_ID($bean->get('File_ID'));
            }
            $finder->filterFile_Name($bean->get('File_Name'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('File_Name', $this->translateValidation('file.name.unique'));
            } else {
                $result = true;
            }
        }
        return $result;
    }

    protected function validateFile_Code(FileBean $bean): bool
    {
        $result = false;
        if ($bean->empty('File_Code')) {
            $this->getValidationHelper()->addError('File_Code', $this->translateValidation('file.code.empty'));
        } else {
            $finder = new FileBeanFinder($this->getDatabaseAdapter());
            if (!$bean->empty('File_ID')) {
                $finder->excludeFile_ID($bean->get('File_ID'));
            }
            $finder->filterFile_Code($bean->get('File_Code'));
            if ($finder->count() > 0) {
                $this->getValidationHelper()->addError('File_Code', $this->translateValidation('file.code.unique'));
            } else {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param FileBean $bean
     * @return bool
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Pars\Pattern\Exception\CoreException
     */
    public function validateFileType_Code(FileBean $bean): bool
    {
        $result= false;
        if ($bean->empty('FileType_Code')) {
            $this->getValidationHelper()->addError('FileType_Code', $this->translateValidation('filetype.code.empty'));
        } else {
            $finder = new FileTypeBeanFinder($this->getDatabaseAdapter());
            $finder->setFileType_Code($bean->get('FileType_Code'));
            $finder->setFileType_Active(true);
            if ($finder->count() !== 1) {
                $this->getValidationHelper()->addError('FileType_Code', $this->translateValidation('filetype.code.invalid'));
            } else {
                $result = true;
            }
        }
        return $result;
    }

    public function validateFileDirectory_ID(FileBean $bean): bool
    {
        $result= false;
        if ($bean->empty('FileDirectory_ID')) {
            $this->getValidationHelper()->addError('FileDirectory_ID', $this->translateValidation('filedirectory.code.empty'));
        } else {
            $result = true;
        }
        return $result;
    }

    /**
    * @return string
    */
    public function getBasePath(): string
    {
        if (!$this->hasBasePath()) {
            throw new CoreException('Base path not set in file bean processor.');
        }
        return $this->basePath;
    }

    /**
    * @param string $basePath
    *
    * @return $this
    */
    public function setBasePath(string $basePath): self
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
    * @return bool
    */
    public function hasBasePath(): bool
    {
        return isset($this->basePath);
    }

}
