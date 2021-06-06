<?php

namespace Pars\Model\Authentication\UserState;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class UserBeanFinder
 * @package Pars\Model\Authentication\User
 * @method UserStateBean getBean(bool $fetchAllData = false)
 * @method UserStateBeanList getBeanList(bool $fetchAllData = false)
 */
class UserStateBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('UserState_Code', 'UserState_Code', 'UserState', 'UserState_Code', true);
        $loader->addColumn('UserState_Active', 'UserState_Active', 'UserState', 'UserState_Code');
    }


}
