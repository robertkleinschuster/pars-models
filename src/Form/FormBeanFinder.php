<?php


namespace Pars\Model\Form;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FormBeanFinder
 * @package Pars\Model\Form
 * @method FormBean getBean(bool $fetchAllData = false)
 */
class FormBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('Form.Form_ID')->setKey(true);
        $loader->addField('Form.FormType_Code');
        $loader->addField('Form.Form_Code');
        $loader->addField('Form.Form_SendEmail');
        $loader->addField('Form.Form_IndexInfo');
        $loader->addDefaultFields('Form');
    }

}
