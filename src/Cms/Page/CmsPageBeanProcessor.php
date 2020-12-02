<?php

namespace Pars\Model\Cms\Page;

use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;
use Laminas\Db\Adapter\Adapter;

/**
 * Class CmsPageBeanProcessor
 * @package Pars\Model\Cms\Page
 */
class CmsPageBeanProcessor extends ArticleTranslationBeanProcessor
{

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
        $saver = $this->getBeanSaver();
        if ($saver instanceof DatabaseBeanSaver) {
            $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'CmsPage_ID', true, null, ['ArticleTranslation', 'CmsPage']);
            $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage', 'CmsPage_ID', true);
            $saver->addColumn('CmsPage_ID_Redirect', 'CmsPage_ID_Redirect', 'CmsPage', 'CmsPage_ID');
            $saver->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPage', 'CmsPage_ID');
            $saver->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPage', 'CmsPage_ID');
        }
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsPageState_Code')) {
            $this->getValidationHelper()->addError('CmsPageState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsPageType_Code')) {
            $this->getValidationHelper()->addError('CmsPageType_Code', $this->translate('articletype.code.empty'));
        }
        return parent::validateForSave($bean);
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('CmsPage_ID') && !$bean->empty('Article_ID');
    }
}
