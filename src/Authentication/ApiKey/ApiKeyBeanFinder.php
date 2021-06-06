<?php


namespace Pars\Model\Authentication\ApiKey;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ApiKeyBeanFinder
 * @package Pars\Model\Authentication\ApiKey
 * @method ApiKeyBean getBean(bool $fetchAllData = false)
 */
class ApiKeyBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('ApiKey_ID')->setTable('ApiKey')->setKey(true);
        $loader->addField('ApiKey_Name')->setTable('ApiKey');
        $loader->addField('ApiKey_Key')->setTable('ApiKey');
        $loader->addField('ApiKey_Host')->setTable('ApiKey');
        $loader->addField('ApiKey_Active')->setTable('ApiKey');
        $loader->addField('Person_ID_Create')->setTable('ApiKey');
        $loader->addField('Person_ID_Edit')->setTable('ApiKey');
        $loader->addField('Timestamp_Create')->setTable('ApiKey');
        $loader->addField('Timestamp_Edit')->setTable('ApiKey');
    }


    /**
     * @param int $id
     * @return $this
     */
    public function setApiKey_ID(int $id): self
    {
        $this->filter(['ApiKey_ID' => $id]);
        return $this;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setApiKey_Host(string $host): self
    {
        $this->filter(['ApiKey_Host' => $host]);
        return $this;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setApiKey_Active(bool $active): self
    {
        $this->filter(['ApiKey_Active' => $active]);
        return $this;
    }

}
