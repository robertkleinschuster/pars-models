<?php
namespace Pars\Model\Form\Data;


use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FormDataBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?int $FormData_ID = null;
    public ?int $Form_ID = null;
    public array $FormData_Data = [];
}
