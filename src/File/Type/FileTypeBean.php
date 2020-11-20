<?php

namespace Pars\Model\File\Type;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class FileTypeBean
 * @package Pars\Model\File\Type
 */
class FileTypeBean extends AbstractBaseBean
{
    public ?string $FileType_Code = null;
    public ?string $FileType_Name = null;
    public ?string $FileType_Mime = null;
    public ?bool $FileType_Active = null;
}
