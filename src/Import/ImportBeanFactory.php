<?php

namespace Pars\Model\Import;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class ImportBeanFactory
 * @package Pars\Model\Import
 */
class ImportBeanFactory extends AbstractBeanFactory
{
    /**
     * @param array $data
     * @return string
     */
    protected function getBeanClass(array $data): string
    {
        return ImportBean::class;
    }

    /**
     * @return string
     */
    protected function getBeanListClass(): string
    {
        return ImportBeanList::class;
    }

}
