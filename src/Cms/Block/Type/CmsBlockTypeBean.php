<?php

namespace Pars\Model\Cms\Block\Type;

use Pars\Bean\Type\Base\AbstractBaseBean;

class CmsBlockTypeBean extends AbstractBaseBean
{
    public ?string $CmsBlockType_Code = null;
    public ?bool $CmsBlockType_Active = null;
    public ?int $CmsBlockType_Order = null;
}
