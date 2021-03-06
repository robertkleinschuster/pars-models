<?php


namespace Pars\Model\Article\Picture;


use Pars\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Bean\Validator\FieldNotEmptyBeanValidator;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\File\FileBean;
use Pars\Model\Picture\PictureBeanProcessor;

class ArticlePictureBeanProcessor extends PictureBeanProcessor
{
    protected function initValidator()
    {
        $this->addSaveValidator(new FieldNotEmptyBeanValidator('Article_ID'));
        $this->addSaveValidator(new FieldNotEmptyBeanValidator('Picture_ID'));
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('Article_ID'));
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('Picture_ID'));
    }

    protected function initSaver(DatabaseBeanSaver $saver)
    {
       $saver->addField('Article_Picture.Article_ID')->setKey(true);
       $saver->addField('Article_Picture.Picture_ID')->setKey(true);
       $saver->addField('Article_Picture.Article_Picture_Order');
    }

    protected function initMetaFieldHandler()
    {
        parent::initMetaFieldHandler();
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new ArticlePictureBeanFinder($this->getDatabaseAdapter()), 'Article_Picture_Order', 'Article_ID'));
    }

    protected function deleteFile(FileBean $bean)
    {
        // do not delete
    }


}
