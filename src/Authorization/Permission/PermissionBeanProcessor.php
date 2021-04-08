<?php

namespace Pars\Model\Authorization\Permission;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Processor\TimestampMetaFieldHandler;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;


class PermissionBeanProcessor extends AbstractBeanProcessor implements ValidationHelperAwareInterface
{
    use ValidationHelperAwareTrait;

    /**
     * UserBeanProcessor constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserPermission', 'UserPermission_Code', true);
        $saver->addColumn('UserPermission_Active', 'UserPermission_Active', 'UserPermission', 'UserPermission_Code');
        parent::__construct($saver);
        $this->addMetaFieldHandler(new TimestampMetaFieldHandler('Timestamp_Edit', 'Timestamp_Create'));
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        return true;
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
