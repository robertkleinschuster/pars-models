<?php


namespace Pars\Model\Picture;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

class PictureBeanFinder extends FileBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new PictureBeanFactory();
    }


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->addField('File.File_ID')->addTable('Picture')->setKey(true);
        $loader->addField('Picture.Picture_ID')->setKey(true)->setJoinField('File_ID');
    }

}
