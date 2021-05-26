<?php


namespace Pars\Model\Form\Data;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Form\FormBeanFactory;

class FormDataBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('FormData.FormData_ID')->setKey(true);
        $loader->addField('FormData.Form_ID');
        $loader->addField('FormData.FormData_Data');
        $loader->addDefaultFields('FormData');
    }

}
