<?php

namespace Pars\Model\Import\Data;


use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class ImportDataBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?int $Import_ID = null;
    public ?int $ImportData_ID = null;
    public ?array $ImportData_Data = null;
    public ?int $ImportData_IntValue1 = null;
    public ?int $ImportData_IntValue2 = null;
    public ?int $ImportData_IntValue3 = null;
    public ?string $ImportData_StringValue1 = null;
    public ?string $ImportData_StringValue2 = null;
    public ?string $ImportData_StringValue3 = null;

}
