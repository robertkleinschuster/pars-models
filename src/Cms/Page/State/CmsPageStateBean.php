<?php

namespace Pars\Model\Cms\Page\State;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPageStateBean
 * @package Pars\Model\Cms\Page\State
 */
class CmsPageStateBean extends AbstractBaseBean
{
    public ?string $CmsPageState_Code = null;
    public ?bool $CmsPageState_Active = null;
}
