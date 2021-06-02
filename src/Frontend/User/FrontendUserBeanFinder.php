<?php


namespace Pars\Model\Frontend\User;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Type\Base\BeanException;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FrontendUserBeanFinder
 * @package Pars\Model\Frontend\User
 * @method FrontendUserBean getBean(bool $fetchAllData = false)
 */
class FrontendUserBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FrontendUserBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('Person.Person_ID')->addTable('FrontendUser')->setKey(true);
        $loader->addField('Person.Person_Firstname');
        $loader->addField('Person.Person_Lastname');
        $loader->addField('FrontendUser.FrontendUser_Username');
        $loader->addField('FrontendUser.FrontendUesr_Password');
    }

    /**
     * @param string $username
     * @param string $password
     * @return FrontendUserBean|null
     * @throws BeanException
     */
    public function authenticate(string $username, string $password): ?FrontendUserBean
    {
        $result = null;
        $this->filterValue('FrontendUser_Username', $username);
        if ($this->count() == 1) {
            $user = $this->getBean();
            if (password_verify($password, $user->password())) {
                $result = $user;
            }
        }
        return $result;
    }
}
