<?php

namespace Pars\Model\Cms\Block;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;

class CmsBlockBeanProcessor extends ArticleTranslationBeanProcessor
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
        $saver = $this->getBeanSaver();
        if ($saver instanceof DatabaseBeanSaver) {
            $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'CmsBlock_ID', true, null, ['ArticleTranslation', 'CmsBlock']);
            $saver->addColumn('CmsBlock_ID', 'CmsBlock_ID', 'CmsBlock', 'CmsBlock_ID', true);
            $saver->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlock', 'CmsBlock_ID');
            $saver->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlock', 'CmsBlock_ID');
        }
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsBlockState_Code')) {
            $this->getValidationHelper()->addError('CmsBlockState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsBlockType_Code')) {
            $this->getValidationHelper()->addError('CmsBlockType_Code', $this->translate('articletype.code.empty'));
        }
        return parent::validateForSave($bean) && !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('CmsBlock_ID') && !$bean->empty('Article_ID');
    }
}