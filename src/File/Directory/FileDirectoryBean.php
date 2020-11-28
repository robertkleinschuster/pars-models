<?php

namespace Pars\Model\File\Directory;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;
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
    public ?BeanListInterface $File_BeanList = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
