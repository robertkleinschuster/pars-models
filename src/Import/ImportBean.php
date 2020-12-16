<?php

namespace Pars\Model\Import;

use DateTime;
use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class ImportBean
 * @package Pars\Model\Import
 */
class ImportBean extends AbstractBaseBean
{
    public ?int $Import_ID = null;
    public ?int $Article_ID = null;
    public ?string $Import_Name = null;
    public ?string $ImportType_Code = null;
    public ?array $Import_Data = null;
    public ?bool $Import_Active = null;
    public ?int $Import_Day = null;
    public ?int $Import_Hour = null;
    public ?int $Import_Minute = null;
    public ?DateTime $Timestamp_Create = null;
    public ?DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
