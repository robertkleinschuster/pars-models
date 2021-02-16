<?php

namespace Pars\Model\Authentication\User;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\TimestampMetaFieldHandler;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class UserBeanProcessor
 * @package Pars\Model\Authentication\User
 */
class UserBeanProcessor extends AbstractBeanProcessor implements
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
     * @var UserBean
     */
    private UserBean $currentUserBean;

    /**
     * UserBeanProcessor constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Person_ID', 'Person_ID', 'Person', 'Person_ID', true, null, ['User']);
        $saver->addColumn('Person_Firstname', 'Person_Firstname', 'Person', 'Person_ID');
        $saver->addColumn('Person_Lastname', 'Person_Lastname', 'Person', 'Person_ID');
        $saver->addColumn('User_Username', 'User_Username', 'User', 'Person_ID');
        $saver->addColumn('User_Displayname', 'User_Displayname', 'User', 'Person_ID');
        $saver->addColumn('User_Password', 'User_Password', 'User', 'Person_ID');
        $saver->addColumn('Locale_Code', 'Locale_Code', 'User', 'Person_ID');
        $saver->addColumn('UserState_Code', 'UserState_Code', 'User', 'Person_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'User', 'Person_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'User', 'Person_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'User', 'Person_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'User', 'Person_ID');

        parent::__construct($saver);
        $this->addMetaFieldHandler(new TimestampMetaFieldHandler('Timestamp_Edit', 'Timestamp_Create'));
    }

    /**
     * @param string $code
     * @return string
     */
    protected function translate(string $code)
    {
        if ($this->hasTranslator()) {
            return $this->getTranslator()->translate($code, 'validation');
        }
        return $code;
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForSave(BeanInterface $bean): bool
    {
        if (!$bean->empty('User_Username')) {
            $finder = new UserBeanFinder($this->adapter);
            $finder->setUser_Username($bean->get('User_Username'));
            if (!$bean->empty('Person_ID')) {
                $finder->setPerson_ID($bean->get('Person_ID'), true);
            }
            if ($finder->count() !== 0) {
                $this->getValidationHelper()->addError('User_Username', $this->translate('user.username.unique'));
            }
        } else {
            $this->getValidationHelper()->addError('User_Username', $this->translate('user.username.empty'));
        }
        if ($bean->empty('User_Displayname')) {
            $this->getValidationHelper()->addError('User_Displayname', $this->translate('user.displayname.empty'));
        }
        if ($bean->empty('Person_Firstname')) {
            $this->getValidationHelper()->addError('Person_Firstname', $this->translate('person.firstname.empty'));
        }
        if ($bean->empty('Person_Lastname')) {
            $this->getValidationHelper()->addError('Person_Lastname', $this->translate('person.lastname.empty'));
        }
        if ($bean->empty('User_Password')) {
            $bean->unset("User_Password");
            if ($bean->empty('Person_ID')) {
                $this->getValidationHelper()->addError('User_Password', $this->translate('user.password.empty'));
            }
        } else {
            if (!isset($bean->get('User_Password')[4])) {
                $this->getValidationHelper()->addError('User_Password', $this->translate('user.password.min_length'));
            }
        }

        if (
            $this->hasCurrentUserBean() &&
            $bean->get('Person_ID') == $this->getCurrentUserBean()->Person_ID &&
            $bean->get('UserState_Code') !== 'active'
        ) {
            $this->getValidationHelper()->addError('UserState_Code', $this->translate('userstate.code.lock_self'));
        }
        return !$this->getValidationHelper()->hasError();
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        $finder = new UserBeanFinder($this->adapter);
        if ($finder->count() == 1) {
            return false;
        }
        if ($this->hasCurrentUserBean() && $bean->get('Person_ID') == $this->getCurrentUserBean()->Person_ID) {
            $this->getValidationHelper()->addError('UserState_Code', $this->translate('user.delete.self'));
        }
        return !$bean->empty('Person_ID') && !$this->getValidationHelper()->hasError();
    }

    /**
     * @param BeanInterface $bean
     */
    public function beforeSave(BeanInterface $bean)
    {
        if (!$bean->empty('User_Password')) {
            $password = $bean->get('User_Password');
            $info = password_get_info($password);
            if ($info['algo'] !== PASSWORD_BCRYPT) {
                $bean->set('User_Password', password_hash($password, PASSWORD_BCRYPT));
            }
        }
    }

    /**
     * @return UserBean
     */
    public function getCurrentUserBean(): UserBean
    {
        return $this->currentUserBean;
    }

    /**
     * @param UserBean $currentUserBean
     *
     * @return $this
     */
    public function setCurrentUserBean(UserBean $currentUserBean): self
    {
        $this->currentUserBean = $currentUserBean;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasCurrentUserBean(): bool
    {
        return isset($this->currentUserBean);
    }

}
