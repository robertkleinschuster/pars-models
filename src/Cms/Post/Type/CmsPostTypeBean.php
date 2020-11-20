<?php

namespace Pars\Model\Cms\Post\Type;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPostTypeBean
 * @package Pars\Model\Cms\Post\Type
 */
class CmsPostTypeBean extends AbstractBaseBean
{
    public ?string $CmsPostType_Code = null;
    public ?bool $CmsPostType_Active = null;
}
