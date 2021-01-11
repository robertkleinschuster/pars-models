<?php


namespace Pars\Model\Config;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

class ConfigBean extends AbstractBaseBean
{
    public ?string $Config_Code = null;
    public ?string $Config_Value = null;
    public ?bool $Config_Locked = null;
    public ?array $Config_Data = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
