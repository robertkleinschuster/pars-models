<?php


namespace Pars\Model\Import\Type;


use Pars\Bean\Type\Base\AbstractBaseBean;

class ImportTypeBean extends AbstractBaseBean
{
    public ?string $ImportType_Code = null;
    public ?bool $ImportType_Active = null;
}
