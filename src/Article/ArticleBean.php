<?php

namespace Pars\Model\Article;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class ArticleBean
 * @package Pars\Model\Article
 */
class ArticleBean extends AbstractBaseBean
{
    public ?int $Article_ID = null;
    public ?string $Article_Code = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
