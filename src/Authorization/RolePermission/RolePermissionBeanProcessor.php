<?php

namespace Pars\Model\Authorization\RolePermission;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Processor\TimestampMetaFieldHandler;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class RolePermissionBeanProcessor
 * @package Pars\Model\Authorization\RolePermission
 */
class RolePermissionBeanProcessor extends AbstractBeanProcessor implements ValidationHelperAwareInterface
{
    use ValidationHelperAwareTrait;

    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserRole_UserPermission', 'UserPermission_Code', true);
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole_UserPermission', 'UserRole_ID', true);
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
