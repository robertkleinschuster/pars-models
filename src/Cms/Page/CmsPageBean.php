<?php

namespace Pars\Model\Cms\Page;

use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsPageBean
 * @package Pars\Model\Cms\Page
 */
class CmsPageBean extends ArticleTranslationBean
{

    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_ID_Redirect = null;
    public ?string $CmsPageType_Code = null;
    public ?string $CmsPageLayout_Code = null;
    public ?string $CmsPageType_Template = null;
    public ?string $CmsPageLayout_Template = null;
    public ?string $CmsPageState_Code = null;

    public function template()
    {
        return $this->CmsPageType_Template;
    }

    public function layout()
    {
        return $this->CmsPageLayout_Template;
    }

    public function blocks()
    {
        if ($this->isset('CmsBlock_BeanList')) {
            return $this->get('CmsBlock_BeanList');
        }
        return [];
    }

    public function posts()
    {
        if ($this->isset('CmsPost_BeanList')) {
            return $this->get('CmsPost_BeanList');
        }
        return [];
    }
}
