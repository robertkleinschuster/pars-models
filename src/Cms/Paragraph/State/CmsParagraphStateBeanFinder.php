<?php

namespace Pars\Model\Cms\Paragraph\State;

use Niceshops\Bean\Finder\AbstractBeanFinder;
use Laminas\Db\Adapter\Adapter;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsParagraphStateBeanFinder
 * @package Pars\Model\Cms\Paragraph\State
 */
class CmsParagraphStateBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsParagraphState_Code', 'CmsParagraphState_Code', 'CmsParagraphState', 'CmsParagraphState_Code', true);
        $loader->addColumn('CmsParagraphState_Active', 'CmsParagraphState_Active', 'CmsParagraphState', 'CmsParagraphState_Code');
        parent::__construct($loader, new CmsParagraphStateBeanFactory());
    }

    public function setCmsParagraphState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsParagraphState_Active', $active);
        return $this;
    }
}
