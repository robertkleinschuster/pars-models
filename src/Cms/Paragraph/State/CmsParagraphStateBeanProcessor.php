<?php

namespace Pars\Model\Cms\Paragraph\State;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsParagraphStateBeanProcessor extends AbstractBeanProcessor
{


    /**
     * CmsParagraphStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsParagraphState_Code', 'CmsParagraphState_Code', 'CmsParagraphState', 'CmsParagraphState_Code', true);
        $saver->addColumn('CmsParagraphState_Active', 'CmsParagraphState_Active', 'CmsParagraphState', 'CmsParagraphState_Code');
        parent::__construct($saver);
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        return true;
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
