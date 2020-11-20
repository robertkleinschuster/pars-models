<?php

namespace Pars\Model\Authentication\User;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;
use Mezzio\Authentication\UserInterface;

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

    public function getIdentity(): string
    {
        return $this->User_Username;
    }

    public function getRoles(): iterable
    {
        return $this->UserRole_BeanList->toArray(true);
    }

    public function getDetail(string $name, $default = null)
    {
        return !$this->empty($name) ? $this->get($name) : $default;
    }

    public function getDetails(): array
    {
        return $this->toArray(true);
    }
}
