<?php

namespace Pars\Model\Article\Translation;

use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\ArticleBean;

/**
 * Class ArticleTranslationBean
 * @package Pars\Model\Article\Translation
 */
class ArticleTranslationBean extends ArticleBean
{
    public ?string $Locale_Code = null;
    public ?string $ArticleTranslation_Code = null;
    public ?string $ArticleTranslation_Host = null;
    public ?bool $ArticleTranslation_Active = true;
    public ?string $ArticleTranslation_Name = null;
    public ?string $ArticleTranslation_Title = null;
    public ?string $ArticleTranslation_Keywords = null;
    public ?string $ArticleTranslation_Heading = null;
    public ?string $ArticleTranslation_SubHeading = null;
    public ?string $ArticleTranslation_Path = null;
    public ?string $ArticleTranslation_Teaser = null;
    public ?string $ArticleTranslation_Text = null;
    public ?string $ArticleTranslation_Footer = null;
    public ?int $File_ID = null;
    public ?BeanListInterface $File_BeanList = null;

    public function template()
    {
        return 'article::default';
    }

    public function layout()
    {
        return 'layout::default';
    }

    public function title()
    {
        return $this->ArticleTranslation_Title;
    }

    public function heading()
    {
        return $this->ArticleTranslation_Heading;
    }

    public function subheading()
    {
        return $this->ArticleTranslation_SubHeading;
    }

    public function text()
    {
        return $this->ArticleTranslation_Text;
    }

    public function teaser()
    {
        return $this->ArticleTranslation_Teaser;
    }

    public function footer()
    {
        return $this->ArticleTranslation_Footer;
    }

    public function pathCode()
    {
        return $this->ArticleTranslation_Code === '/' ? null : $this->ArticleTranslation_Code;
    }

    public function menuName()
    {
        return $this->ArticleTranslation_Name;
    }

    public function code()
    {
        return $this->Article_Code;
    }

    public function path()
    {
        return $this->ArticleTranslation_Path;
    }

    public function keywords()
    {
        return $this->ArticleTranslation_Keywords;
    }

    public function tpl()
    {
        return $this->template();
    }

    public function description()
    {
        return strip_tags($this->teaser());
    }

    public function image()
    {
        if ($this->File_BeanList) {
            return $this->File_BeanList->first();
        }
        return null;
    }

    public function img()
    {
        return $this->image();
    }
}
