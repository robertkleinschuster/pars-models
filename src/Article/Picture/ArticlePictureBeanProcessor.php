<?php


namespace Pars\Model\Article\Picture;


use Pars\Bean\Validator\FieldNotEmptyBeanValidator;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class ArticlePictureBeanProcessor extends AbstractDatabaseBeanProcessor
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
    }

}
