<?php

namespace Pars\Model\Authentication\User;

use Mezzio\Authentication\UserInterface;
use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;
use Pars\Core\Localization\LocaleAwareInterface;
use Pars\Core\Localization\LocaleInterface;

/**
 * Class UserBean
 * @package Pars\Model\Authentication\User
 */
class UserBean extends AbstractBaseBean implements UserInterface, LocaleAwareInterface
{

    public ?int $Person_ID = null;
    public ?string $Person_Firstname = null;
    public ?string $Person_Lastname = null;
    public ?string $User_Username = null;
    public ?string $User_Displayname = null;
    public ?string $User_Password = null;
    public ?string $Locale_Code = 'de_AT';
    public ?string $Locale_Name = null;
    public ?string $UserState_Code = null;
    public ?BeanListInterface $UserRole_BeanList = null;
    public ?BeanListInterface $Locale_BeanList = null;
    public ?array $roles = null;
    public ?array $permissions = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;

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

    public function getLocale(): LocaleInterface
    {
        return $this->Locale_BeanList->first();
    }

    public function hasLocale(): bool
    {
        return null !== $this->Locale_BeanList && !$this->Locale_BeanList->isEmpty();
    }
}
