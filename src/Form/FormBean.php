<?php

namespace Pars\Model\Form;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Core\Database\DefaultBeanFieldTrait;
use Pars\Core\Template\TemplateRenderableBeanInterface;
use Pars\Model\Form\Field\FormFieldBeanList;

class FormBean extends AbstractBaseBean implements TemplateRenderableBeanInterface
{
    use DefaultBeanFieldTrait;
    public ?int $Form_ID = null;
    public ?string $FormType_Code = null;
    public ?string $Form_Code = null;
    public ?bool $Form_SendEmail = false;
    public ?bool $Form_IndexInfo = null;
    public ?BeanListInterface $FormField_BeanList = null;

    public function template()
    {
        return 'form::default';
    }

    public function code()
    {
        return $this->Form_Code;
    }

    public function fields()
    {
        if (!isset($this->FormField_BeanList)) {
            $this->FormField_BeanList = new FormFieldBeanList();
        }
        return $this->FormField_BeanList;
    }

}
