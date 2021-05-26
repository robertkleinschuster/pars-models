<?php
namespace Pars\Model\Form\Field;


use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FormFieldBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?int $FormField_ID = null;
    public ?int $Form_ID = null;
    public ?int $FormField_Order = null;
    public ?string $FormFieldType_Code = null;
    public ?string $FormField_Code = null;
    public ?bool $FormField_Required = null;

    public function code()
    {
        return $this->FormField_Code;
    }

    public function fieldType()
    {
        return $this->FormFieldType_Code;
    }

    public function required()
    {
        return $this->FormField_Required;
    }

}
