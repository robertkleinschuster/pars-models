<?php

namespace Pars\Model\Cms\Menu\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsMenuTypeBean
 * @package Pars\Model\Cms\Menu\Type
 */
class CmsMenuTypeBean extends AbstractBaseBean
{
    public ?string $CmsMenuType_Code = null;
    public ?bool $CmsMenuType_Active = null;
}
