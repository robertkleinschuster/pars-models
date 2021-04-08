<?php


namespace Pars\Model\Authentication\ApiKey;


use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ApiKeyBeanFinder
 * @package Pars\Model\Authentication\ApiKey
 * @method ApiKeyBean getBean(bool $fetchAllData = false)
 */
class ApiKeyBeanFinder extends AbstractBeanFinder
{
    /**
     * ApiKeyBeanFinder constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addField('ApiKey_ID')->setTable('ApiKey')->setKey(true);
        $loader->addField('ApiKey_Name')->setTable('ApiKey');
        $loader->addField('ApiKey_Key')->setTable('ApiKey');
        $loader->addField('ApiKey_Host')->setTable('ApiKey');
        $loader->addField('ApiKey_Active')->setTable('ApiKey');
        $loader->addField('Person_ID_Create')->setTable('ApiKey');
        $loader->addField('Person_ID_Edit')->setTable('ApiKey');
        $loader->addField('Timestamp_Create')->setTable('ApiKey');
        $loader->addField('Timestamp_Edit')->setTable('ApiKey');
        parent::__construct($loader, new ApiKeyBeanFactory());
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
