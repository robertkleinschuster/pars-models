<?php


namespace Pars\Model\Picture;


use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\File\FileBeanProcessor;

class PictureBeanProcessor extends FileBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        parent::initSaver($saver);
        $saver->addField('File.File_ID')->addTable('Picture')->setKey(true);
        $saver->addField('Picture.Picture_ID')->setKey(true)->setJoinField('File_ID');
    }

}
