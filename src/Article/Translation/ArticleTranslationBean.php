<?php

namespace Pars\Model\Article\Translation;

use Niceshops\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\ArticleBean;

/**
 * Class ArticleTranslationBean
 * @package Pars\Model\Article\Translation
 */
class ArticleTranslationBean extends ArticleBean
{
    public ?string $Locale_Code = null;
    public ?string $ArticleTranslation_Code = null;
    public ?string $ArticleTranslation_Name = null;
    public ?string $ArticleTranslation_Title = null;
    public ?string $ArticleTranslation_Heading = null;
    public ?string $ArticleTranslation_SubHeading = null;
    public ?string $ArticleTranslation_Teaser = null;
    public ?string $ArticleTranslation_Text = null;
    public ?string $ArticleTranslation_Footer = null;
    public ?int $File_ID = null;
    public ?BeanListInterface $File_BeanList = null;
}
