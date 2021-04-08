<?php

namespace Pars\Model\Article\Data;

use Pars\Bean\Type\Base\AbstractBaseBean;

/**
 * Class ArticleDataBean
 * @package Pars\Model\Article\Data
 */
class ArticleDataBean extends AbstractBaseBean
{
    public ?int $ArticleData_ID = null;
    public ?int $Article_ID = null;
    public ?array $ArticleData_Data = null;
    public ?bool $ArticleData_Active = null;
    public ?\DateTime $ArticleData_Timestamp = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
