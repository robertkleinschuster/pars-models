<?php

namespace Pars\Model\Localization\Locale;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\OrderMetaFieldHandlerInterface;
use Niceshops\Bean\Processor\TimestampMetaFieldHandler;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class LocaleBeanProcessor
 * @package Pars\Model\Localization\Locale
 */
class LocaleBeanProcessor extends AbstractBeanProcessor
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Locale_Code', 'Locale_Code', 'Locale', 'Locale_Code', true);
        $saver->addColumn('Locale_Name', 'Locale_Name', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_UrlCode', 'Locale_UrlCode', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_Active', 'Locale_Active', 'Locale', 'Locale_Code');
        $saver->addColumn('Locale_Order', 'Locale_Order', 'Locale', 'Locale_Code');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Locale', 'Locale_Code');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Locale', 'Locale_Code');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Locale', 'Locale_Code');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Locale', 'Locale_Code');
        parent::__construct($saver);
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new LocaleBeanFinder($adapter), 'Locale_Order'));
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
