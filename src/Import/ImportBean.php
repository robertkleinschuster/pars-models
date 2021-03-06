<?php

namespace Pars\Model\Import;

use DateTime;
use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Template\TemplateRenderableBeanInterface;

/**
 * Class ImportBean
 * @package Pars\Model\Import
 */
class ImportBean extends AbstractBaseBean implements TemplateRenderableBeanInterface
{
    public ?int $Import_ID = null;
    public ?string $Import_Name = null;
    public ?string $Import_Code = null;
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
    public ?int $ImportData_IntValue1_AVG = null;
    public ?int $ImportData_IntValue2_AVG = null;
    public ?int $ImportData_IntValue3_AVG = null;
    public ?string $ImportData_StringValue1_List = null;
    public ?string $ImportData_StringValue2_List = null;
    public ?string $ImportData_StringValue3_List = null;

    public function code()
    {
        return $this->Import_Code;
    }

    public function template()
    {
        return 'import::tesla';
    }

    public function data()
    {
        return $this->Import_Data;
    }
}
