<?php

namespace Pars\Model\Frontend\Statistic;

use Pars\Bean\Factory\AbstractBeanFactory;

class FrontendStatisticBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FrontendStatisticBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FrontendStatisticBeanList::class;
    }

}
