<?php


namespace Pars\Model\Task\Log;


use Pars\Bean\Factory\AbstractBeanFactory;

class TaskLogBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return TaskLogBean::class;
    }

    protected function getBeanListClass(): string
    {
        return TaskLogBeanList::class;
    }

}
