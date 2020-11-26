<?php

namespace Pars\Model\Authentication\User;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;
use Mezzio\Authentication\UserInterface;
use Pars\Model\Authorization\Permission\PermissionBeanList;
use Pars\Model\Authorization\UserRole\UserRoleBeanList;

/**
 * Class UserBean
 * @package Pars\Model\Authentication\User
 */
class UserBean extends AbstractBaseBean implements UserInterface
{

    public ?int $Person_ID = null;
    public ?string $Person_Firstname = null;
    public ?string $Person_Lastname = null;
    public ?string $User_Username = null;
    public ?string $User_Displayname = null;
    public ?string $User_Password = null;
    public ?string $Locale_Code = 'de_AT';
    public ?string $UserState_Code = null;
    public ?BeanListInterface $UserRole_BeanList = null;
    public ?array $roles = null;
    public ?array $permissions = null;

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->User_Username;
    }

    /**
     * @return iterable
     */
    public function getRoles(): iterable
    {
        if (null === $this->roles) {
            $this->roles = [];
            if (null !== $this->UserRole_BeanList) {
                $this->roles = $this->UserRole_BeanList->column('UserRole_Code', 'UserRole_ID');
            }
        }
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        if (null === $this->permissions) {
            $data = [];
            if (null === $this->UserRole_BeanList) {
                return $data;
            }
            foreach ($this->UserRole_BeanList as $role) {
                $data = array_replace($data, $role->UserPermission_BeanList->column('UserPermission_Code'));
            }
            $this->permissions = $data;
        }
        return $this->permissions;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function hasPermission(string $code): bool
    {
        return in_array($code, $this->getPermissions());
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     * @throws \Niceshops\Bean\Type\Base\BeanException
     */
    public function getDetail(string $name, $default = null)
    {
        return !$this->empty($name) ? $this->get($name) : $default;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->toArray(true);
    }
}
