<?php

namespace Pars\Model\Cms\Menu;


use Pars\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;



/**
 * Class CmsMenuBeanProcessor
 * @package Pars\Model\Cms\Menu
 */
class CmsMenuBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsMenu_ID', 'CmsMenu_ID', 'CmsMenu', 'CmsMenu_ID', true);
        $saver->addColumn('CmsMenu_ID_Parent', 'CmsMenu_ID_Parent', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsPage_ID_Parent', 'CmsPage_ID_Parent', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenu_Name', 'CmsMenu_Name', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenu_Order', 'CmsMenu_Order', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenu_Level', 'CmsMenu_Level', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsMenu', 'CmsMenu_ID');

    }

    protected function initMetaFieldHandler()
    {
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new CmsMenuBeanFinder($this->getDatabaseAdapter()), 'CmsMenu_Order', 'CmsMenu_ID_Parent'));
    }


    protected function initValidator()
    {

    }

    public function translate(string $code, array $vars = [], ?string $namespace = null): string
    {
       return $this->translateValidation($code, $vars);
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsMenuState_Code')) {
            $this->getValidationHelper()->addError('CmsMenuState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsMenuType_Code') && $bean->empty('CmsMenu_ID_Parent')) {
            $this->getValidationHelper()->addError('CmsMenuType_Code', $this->translate('articletype.code.empty'));
        }
        return parent::validateForSave($bean) && !$this->getValidationHelper()->hasError();
    }
}
