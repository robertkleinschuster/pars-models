<?php

namespace Pars\Model\Frontend\User;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class FrontendUserBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;

    public ?int $Person_ID = null;
    public ?string $Person_Firstname = null;
    public ?string $Person_Lastname = null;
    public ?string $FrontendUser_Username = null;
    public ?string $FrontendUser_Password = null;

}
