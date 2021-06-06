<?php

namespace Pars\Model\Cms\Page;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;

/**
 * Class CmsPageBeanProcessor
 * @package Pars\Model\Cms\Page
 */
class CmsPageBeanProcessor extends ArticleTranslationBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        parent::initSaver($saver);
        $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'CmsPage_ID', true, null, ['ArticleTranslation', 'CmsPage']);
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage', 'CmsPage_ID', true);
        $saver->addColumn('CmsPage_ID_Redirect', 'CmsPage_ID_Redirect', 'CmsPage', 'CmsPage_ID');
        $saver->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPage', 'CmsPage_ID');
        $saver->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPage', 'CmsPage_ID');
        $saver->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPage', 'CmsPage_ID');
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsPageState_Code')) {
            $this->getValidationHelper()->addError('CmsPageState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsPageType_Code')) {
            $this->getValidationHelper()->addError('CmsPageType_Code', $this->translate('articletype.code.empty'));
        }
        if ($bean->empty('CmsPageLayout_Code')) {
            $this->getValidationHelper()->addError('CmsPageLayout_Code', $this->translate('articlelayout.code.empty'));
        } elseif ($bean->get('CmsPageLayout_Code') == 'big_image' && $bean->empty('File_ID')) {
            $this->getValidationHelper()->addError('File_ID', $this->translate('file.id.empty'));
        }
        return parent::validateForSave($bean) && !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('CmsPage_ID') && !$bean->empty('Article_ID');
    }
}
