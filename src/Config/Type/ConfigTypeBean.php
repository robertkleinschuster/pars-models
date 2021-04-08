<?php

namespace Pars\Model\Config\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class ConfigTypeBean
 * @package Pars\Model\Config\Type
 */
class ConfigTypeBean extends AbstractBaseBean
{
    public ?string $ConfigType_Code = null;
    public ?string $ConfigType_Code_Parent = null;
    public ?bool $ConfigType_Active = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
