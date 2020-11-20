<?php

namespace Pars\Model\File;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class FileBean
 * @package Pars\Model\File
 */
class FileBean extends AbstractBaseBean
{
    public ?int $File_ID = null;
    public ?string $File_Code = null;
    public ?string $File_Name = null;
    public ?string $FileType_Code = null;
    public ?string $FileType_Mime = null;
    public ?string $FileType_Name = null;
    public ?int $FileDirectory_ID = null;
    public ?string $FileDirectory_Code = null;
    public ?string $FileDirectory_Name = null;
}
