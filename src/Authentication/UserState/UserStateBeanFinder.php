<?php

namespace Pars\Model\Authentication\UserState;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class UserBeanFinder
 * @package Pars\Model\Authentication\User
 * @method UserStateBean getBean(bool $fetchAllData = false)
 * @method UserStateBeanList getBeanList(bool $fetchAllData = false)
 */
class UserStateBeanFinder extends AbstractBeanFinder
{

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * UserBeanFinder constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('UserState_Code', 'UserState_Code', 'UserState', 'UserState_Code', true);
        $loader->addColumn('UserState_Active', 'UserState_Active', 'UserState', 'UserState_Code');
        parent::__construct($loader, new UserStateBeanFactory());
    }
}
