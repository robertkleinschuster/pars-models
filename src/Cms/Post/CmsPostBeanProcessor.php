<?php

namespace Pars\Model\Cms\Post;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;

/**
 * Class CmsPostBeanProcessor
 * @package Pars\Model\Cms\Post
 */
class CmsPostBeanProcessor extends ArticleTranslationBeanProcessor
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
        $saver = $this->getBeanSaver();
        if ($saver instanceof DatabaseBeanSaver) {
            $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'CmsPost_ID', true, null, ['ArticleTranslation', 'CmsPost']);
            $saver->addColumn('CmsPost_ID', 'CmsPost_ID', 'CmsPost', 'CmsPost_ID', true);
            $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPost', 'CmsPage_ID');
            $saver->addColumn('CmsPost_PublishTimestamp', 'CmsPost_PublishTimestamp', 'CmsPost', 'CmsPage_ID');
            $saver->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPost', 'CmsPost_ID');
            $saver->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPost', 'CmsPost_ID');
        }
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsPostState_Code')) {
            $this->getValidationHelper()->addError('CmsPostState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsPostType_Code')) {
            $this->getValidationHelper()->addError('CmsPostType_Code', $this->translate('articletype.code.empty'));
        }
        if ($bean->empty('CmsPage_ID')) {
            $this->getValidationHelper()->addError('CmsPage_ID', $this->translate('cmspage.id.empty'));
        }
        if ($bean->empty('CmsPost_PublishTimestamp')) {
            $this->getValidationHelper()->addError('CmsPost_PublishTimestamp', $this->translate('cmspost.publishtimestamp.empty'));
        }
        return parent::validateForSave($bean) && !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('CmsPost_ID') && !$bean->empty('Article_ID');
    }
}
