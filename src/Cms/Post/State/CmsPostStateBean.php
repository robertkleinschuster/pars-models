<?php

namespace Pars\Model\Cms\Post\State;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPostStateBean
 * @package Pars\Model\Cms\Post\State
 */
class CmsPostStateBean extends AbstractBaseBean
{
    public ?string $CmsPostState_Code = null;
    public ?bool $CmsPostState_Active = null;
}
