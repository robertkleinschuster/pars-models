<?php

namespace Pars\Model\Authentication\UserState;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

class UserStateBean extends AbstractBaseBean
{
    public ?string $UserState_Code = null;
    public ?bool $UserState_Active = null;
}
