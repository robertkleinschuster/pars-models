<?php
namespace Pars\Model\Form\Field\Type;


use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Bean\Type\Base\AbstractBaseBeanList;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FormFieldTypeBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?string $FormFieldType_Code = null;
    public ?bool $FormFieldType_Active = null;
    public ?int $FormFieldType_Order = null;
}
