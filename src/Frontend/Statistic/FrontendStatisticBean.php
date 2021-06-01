<?php
namespace Pars\Model\Frontend\Statistic;


use Pars\Bean\Type\Base\AbstractBaseBean;

class FrontendStatisticBean extends AbstractBaseBean
{
    public ?int $FrontendStatistic_ID = null;
    public ?string $FrontendStatistic_Group = null;
    public ?string $FrontendStatistic_Reference = null;
    public ?string $FrontendStatistic_Locale = null;
    public ?array $FrontendStatistic_Data = null;
}
