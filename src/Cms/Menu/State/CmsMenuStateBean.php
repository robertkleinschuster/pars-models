<?php

namespace Pars\Model\Cms\Menu\State;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsMenuStateBean
 * @package Pars\Model\Cms\Menu\State
 */
class CmsMenuStateBean extends AbstractBaseBean
{
    public ?string $CmsMenuState_Code = null;
    public ?bool $CmsMenuState_Active = null;
}
