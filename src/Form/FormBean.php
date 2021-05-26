<?php

namespace Pars\Model\Form;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FormBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?int $Form_ID = null;
    public ?string $FormType_Code = null;
    public ?string $Form_Code = null;
    public ?BeanListInterface $FormField_BeanList = null;

}
