<?php
namespace Pars\Model\Picture;


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
