<?php

namespace Pars\Model\Cms\Menu;

use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsMenuBean
 * @package Pars\Model\Cms\Menu
 */
class CmsMenuBean extends ArticleTranslationBean
{
    public ?int $CmsMenu_ID = null;
    public ?int $CmsMenu_ID_Parent = null;
    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_ID_Parent = null;
    public ?int $CmsMenu_Order = null;
    public ?string $CmsMenuType_Code = null;
    public ?string $CmsMenuType_Template = null;
    public ?string $CmsMenuState_Code = null;
    public ?\DateTime $Timestamp_Edit_Article = null;
    public ?BeanListInterface $Menu_BeanList = null;

    public function lastmod()
    {
        $result =  $this->Timestamp_Edit_Article;
        if ($result) {
            $result = $result->format(\DateTimeInterface::W3C);
        }
        return $result;
    }

    public function items()
    {
        return $this->Menu_BeanList ?? [];
    }

    public function menuType()
    {
        return $this->CmsMenuType_Code;
    }


    public function template()
    {
        return $this->CmsMenuType_Template;
    }
}
