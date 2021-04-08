<?php

namespace Pars\Model\Cms\Post\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPostTypeBean
 * @package Pars\Model\Cms\Post\Type
 */
class CmsPostTypeBean extends AbstractBaseBean
{
    public ?string $CmsPostType_Code = null;
    public ?string $CmsPostType_Template = null;
    public ?bool $CmsPostType_Active = null;
}
