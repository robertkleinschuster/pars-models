<?php


namespace Pars\Model\Form\Type;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class FormTypeBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormTypeBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('FormType.FormType_Code')->setKey(true);
        $loader->addField('FormType.FormType_Active');
        $loader->addField('FormType.FormType_Order');
        $loader->addDefaultFields('FormType');
        $loader->addOrder('FormType_Order');
    }
}
