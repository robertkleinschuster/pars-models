<?php

namespace Pars\Model\Cms\Paragraph\Type;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsParagraphTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * CmsParagraphStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsParagraphType_Code', 'CmsParagraphType_Code', 'CmsParagraphType', 'CmsParagraphType_Code', true);
        $saver->addColumn('CmsParagraphType_Active', 'CmsParagraphType_Active', 'CmsParagraphType', 'CmsParagraphType_Code');
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
