<?php

namespace Pars\Model\Cms\PageBlock;

use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsPageBlockBean
 * @package Pars\Model\Cms\PageBlock
 */
class CmsPageBlockBean extends ArticleTranslationBean
{
    public ?int $CmsBlock_ID = null;
    public ?int $CmsBlock_ID_Parent = null;
    public ?int $CmsBlock_Order = null;
    public ?string $CmsBlockType_Code = null;
    public ?string $CmsBlockType_Template = null;
    public ?string $CmsBlockState_Code = null;
    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_CmsBlock_Order = null;
    public ?BeanListInterface $CmsBlock_BeanList = null;
}
