<?php


namespace Pars\Model\Article\Picture;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Picture\PictureBeanFinder;

class ArticlePictureBeanFinder extends PictureBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ArticlePictureBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->addField('Article_Picture.Article_ID')
            ->setKey(true)
            ->setJoinTableSelf('Picture')
            ->setJoinField('Picture_ID');
        $loader->addField('Picture.Picture_ID')
            ->addTable('Article_Picture')
            ->setKey(true)
            ->setJoinTableSelf('File')
            ->setJoinField('File_ID');
        $loader->addField('Article_Picture.Article_Picture_Order');
        $loader->order(['Article_Picture_Order']);
    }


}
