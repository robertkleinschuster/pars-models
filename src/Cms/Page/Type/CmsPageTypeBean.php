<?php

namespace Pars\Model\Cms\Page\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPageTypeBean
 * @package Pars\Model\Cms\Page\Type
 */
class CmsPageTypeBean extends AbstractBaseBean
{
    public ?string $CmsPageType_Code = null;
    public ?string $CmsPageType_Template = null;
    public ?bool $CmsPageType_Active = null;
    public ?int $CmsPageType_Order = null;
}
