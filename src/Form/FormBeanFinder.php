<?php


namespace Pars\Model\Form;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class FormBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('Form.Form_ID')->setKey(true);
        $loader->addField('Form.Form_Code');
        $loader->addField('Form.FormType_Code');
        $loader->addDefaultFields('Form');
    }

}
