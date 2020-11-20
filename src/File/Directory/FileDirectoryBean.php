<?php

namespace Pars\Model\File\Directory;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Pars\Model\File\FileBeanList;

/**
 * Class FileDirectoryBean
 * @package Pars\Model\File\Directory
 */
class FileDirectoryBean extends AbstractBaseBean
{
    public ?int $FileDirectory_ID = null;
    public ?string $FileDirectory_Code = null;
    public ?string $FileDirectory_Name = null;
    public ?bool $FileDirectory_Active = null;
    public ?FileBeanList $File_BeanList = null;
}
