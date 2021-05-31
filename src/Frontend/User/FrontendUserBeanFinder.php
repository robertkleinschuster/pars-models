<?php


namespace Pars\Model\Frontend\User;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class FrontendUserBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FrontendUserBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('Person.Person_ID')->addTable('FrontendUser')->setKey(true);
        $loader->addField('Person.Person_Firstname');
        $loader->addField('Person.Person_Lastname');
        $loader->addField('FrontendUser.FrontendUser_Username');
        $loader->addField('FrontendUser.FrontendUesr_Password');
    }

}
