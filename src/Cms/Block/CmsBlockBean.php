<?php

namespace Pars\Model\Cms\Block;

use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsBlockBean extends ArticleTranslationBean
{

    public ?int $CmsBlock_ID = null;
    public ?int $CmsBlock_ID_Parent = null;
    public ?int $CmsBlock_Order = null;
    public ?string $CmsBlockType_Code = null;
    public ?string $CmsBlockType_Template = null;
    public ?string $CmsBlockState_Code = null;
    public ?BeanListInterface $CmsBlock_BeanList = null;
}
