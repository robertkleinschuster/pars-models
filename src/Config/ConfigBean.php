<?php

namespace Pars\Model\Config;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class ConfigBean
 * @package Pars\Model\Config
 */
class ConfigBean extends AbstractBaseBean
{
    public ?string $Config_Code = null;
    public ?string $Config_Value = null;
    public ?string $Config_Description = '';
    public ?bool $Config_Locked = null;
    public ?array $Config_Data = null;
    public ?array $Config_Options = null;
    public ?string $ConfigType_Code = null;
    public ?string $ConfigType_Code_Parent = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
