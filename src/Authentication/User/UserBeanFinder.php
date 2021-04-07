<?php

namespace Pars\Model\Authentication\User;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;
use Pars\Model\Authorization\UserRole\UserRoleBeanFinder;
use Pars\Model\Localization\Locale\LocaleBeanFinder;

/**
 * Class UserBeanFinder
 * @package Pars\Model\Authentication\User
 * @method UserBean getBean(bool $fetchAllData = false)
 * @method UserBeanList getBeanList(bool $fetchAllData = false)
 */
class UserBeanFinder extends AbstractBeanFinder implements
    UserRepositoryInterface,
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;


    /**
     * @var Adapter
     */
    private Adapter $adapter;

    /**
     * UserBeanFinder constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('Person_ID', 'Person_ID', 'Person', 'Person_ID', true, null, ['User']);
        $loader->addColumn('Person_Firstname', 'Person_Firstname', 'Person', 'Person_ID');
        $loader->addColumn('Person_Lastname', 'Person_Lastname', 'Person', 'Person_ID');
        $loader->addColumn('User_Username', 'User_Username', 'User', 'Person_ID');
        $loader->addColumn('User_Displayname', 'User_Displayname', 'User', 'Person_ID');
        $loader->addColumn('User_Password', 'User_Password', 'User', 'Person_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'User', 'Person_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'User', 'Person_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'User', 'Person_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'User', 'Person_ID');
        $loader->addColumn('Locale_Code', 'Locale_Code', 'User', 'Person_ID');
        $loader->addColumn('Locale_Name', 'Locale_Name', 'Locale', 'Locale_Code', false, null, [], 'User');
        $loader->addColumn('UserState_Code', 'UserState_Code', 'User', 'Person_ID');
        $loader->addField('User_LastLogin')->setTable('User');
        parent::__construct($loader, new UserBeanFactory());
        $userRoleFinder = new UserRoleBeanFinder($adapter);
        $userRoleFinder->setUserRole_Active(true);
        $this->addLinkedFinder($userRoleFinder, 'UserRole_BeanList', 'Person_ID', 'Person_ID');
        $this->addLinkedFinder(new LocaleBeanFinder($adapter), 'Locale_BeanList', 'Locale_Code', 'Locale_Code');
    }

    /**
     * @param string $credential
     * @param string|null $password
     * @return UserInterface|null
     */
    public function authenticate(string $credential, string $password = null): ?UserInterface
    {
        $this->setUser_Username($credential);
        $this->setUserState_Code('active');
        if ($this->count() === 1) {
            $bean = $this->getBean(true);
            if (password_verify($password, $bean->get('User_Password'))) {
                $processor = new UserBeanProcessor($this->adapter);
                $bean->User_LastLogin = new \DateTime();
                $list = $this->getBeanFactory()->getEmptyBeanList();
                $list->push($bean);
                $processor->setBeanList($list);
                $processor->save();
                return $bean;
            } else {
                $this->getValidationHelper()->addError('User_Password', $this->translate('user.password.invalid'));
            }
        } else {
            $this->getValidationHelper()->addError('User_Username', $this->translate('user.username.invalid'));
        }
        return null;
    }

    /**
     * @param string $message
     * @return string
     */
    protected function translate(string $message)
    {
        if ($this->hasTranslator()) {
            return $this->getTranslator()->translate($message, 'validation');
        }
        return $message;
    }

    /**
     * @param int $person_id
     * @param bool $exclude
     * @return $this
     */
    public function setPerson_ID(int $person_id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('Person_ID', $person_id);
        } else {
            $this->getBeanLoader()->filterValue('Person_ID', $person_id);
        }
        return $this;
    }

    /**
     * @param string $user_username
     * @return $this
     */
    public function setUser_Username(string $user_username): self
    {
        $this->getBeanLoader()->filterValue('User_Username', $user_username);
        return $this;
    }


    /**
     * @param string $userState_Code
     * @return $this
     */
    public function setUserState_Code(string $userState_Code): self
    {
        $this->getBeanLoader()->filterValue('UserState_Code', $userState_Code);
        return $this;
    }
}
