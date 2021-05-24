<?php


namespace Pars\Model\Article\Picture;


use Pars\Bean\Factory\AbstractBeanFactory;

class ArticlePictureBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ArticlePictureBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ArticlePictureBeanList::class;
    }

}
