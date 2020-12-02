<?php

namespace Pars\Model\Article;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanInterface;

/**
 * Class ArticleBean
 * @package Pars\Model\Article
 */
class ArticleBean extends AbstractBaseBean
{
    public ?int $Article_ID = null;
    public ?string $Article_Code = null;
    public ?BeanInterface $Article_Data = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;

    /**
     * @return ArticleDataBean
     */
    public function getArticle_Data(): ArticleDataBean
    {
        if ($this->Article_Data === null) {
            $this->Article_Data = new ArticleDataBean();
        }
        return $this->Article_Data;
    }
}
