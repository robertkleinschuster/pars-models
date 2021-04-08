<?php

namespace Pars\Model\Authorization\UserRole;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class UserRoleBeanProcessor
 * @package Pars\Model\Authorization\UserRole
 */
class UserRoleBeanProcessor extends AbstractBeanProcessor implements ValidationHelperAwareInterface
{
    use ValidationHelperAwareTrait;

    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'User_UserRole', 'UserRole_ID', true);
        $saver->addColumn('Person_ID', 'Person_ID', 'User_UserRole', 'Person_ID', true);
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'User_UserRole', 'UserRole_ID');

        parent::__construct($saver);
    }


    /**
     * @inheritDoc
     */
    protected function validateForSave(BeanInterface $bean): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
