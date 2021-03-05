<?php


namespace Pars\Model\Authentication\ApiKey;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

class ApiKeyBean extends AbstractBaseBean
{
    public ?int $ApiKey_ID = null;
    public ?string $ApiKey_Name = null;
    public ?string $ApiKey_Key = null;
    public ?string $ApiKey_Host = null;
    public ?bool $ApiKey_Active = true;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
