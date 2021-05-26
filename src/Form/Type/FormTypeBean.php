<?php
namespace Pars\Model\Form\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FormTypeBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?string $FormType_Code = null;
    public ?bool $FormType_Active = null;
    public ?int $FormType_Order = null;
}
