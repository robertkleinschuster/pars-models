<?php

namespace Pars\Model\Article;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Bean\Type\Base\BeanListInterface;

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
    public ?BeanListInterface $ArticleData_BeanList = null;
    public ?BeanListInterface $ArticlePicture_BeanList = null;

    /**
     * @return DataBean
     */
    public function getArticle_Data(): DataBean
    {
        if ($this->Article_Data === null) {
            $this->Article_Data = new DataBean();
        }
        return $this->Article_Data;
    }
}
