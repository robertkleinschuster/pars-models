<?php
namespace Pars\Model\Picture;


/**
 * Class PictureBeanFactory
 * @package Pars\Model\Picture
 * @method PictureBean getEmptyBean(array $data)
 * @method PictureBeanList getEmptyBeanList()
 */
class PictureBeanFactory extends \Pars\Bean\Factory\AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return PictureBean::class;
    }

    protected function getBeanListClass(): string
    {
        return PictureBeanList::class;
    }

}
