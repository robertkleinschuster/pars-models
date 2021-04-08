<?php

namespace Pars\Model\Cms\Page\Layout;


use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class CmsPageLayoutBean
 * @package Pars\Model\Cms\Page\Layout
 */
class CmsPageLayoutBean extends AbstractBaseBean
{
    public ?string $CmsPageLayout_Code = null;
    public ?string $CmsPageLayout_Template = null;
    public ?bool $CmsPageLayout_Active = null;
}
