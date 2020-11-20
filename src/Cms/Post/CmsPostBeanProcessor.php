<?php

namespace Pars\Model\Cms\Post;

use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;
use Laminas\Db\Adapter\Adapter;

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
        return parent::validateForSave($bean);
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('CmsPost_ID') && !$bean->empty('Article_ID');
    }
}
