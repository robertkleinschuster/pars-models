<?php


namespace Pars\Model\Picture;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\FinderBeanListDecorator;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

/**
 * Class PictureBeanFinder
 * @package Pars\Model\Picture
 *
 * @method PictureBeanFactory getBeanFactory()
 */
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
