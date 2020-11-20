<?php

namespace Pars\Model\Cms\Menu;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Finder\BeanFinderInterface;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;


/**
 * Class CmsMenuBeanProcessor
 * @package Pars\Model\Cms\Menu
 */
class CmsMenuBeanProcessor extends AbstractBeanProcessor implements
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    private $adapter;
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsMenu_ID', 'CmsMenu_ID', 'CmsMenu', 'CmsMenu_ID', true);
        $saver->addColumn('CmsMenu_ID_Parent', 'CmsMenu_ID_Parent', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsPage_ID_Parent', 'CmsPage_ID_Parent', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenu_Order', 'CmsMenu_Order', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenu', 'CmsMenu_ID');
        $saver->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenu', 'CmsMenu_ID');
        parent::__construct($saver);
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->empty('CmsMenu_Order')) {
            $order = 1;
            $finder = new CmsMenuBeanFinder($this->adapter);
            $finder->order(['CmsMenu_Order' => BeanFinderInterface::ORDER_MODE_ASC]);
            $finder->limit(1, 0);
            if ($finder->count() == 1) {
                $lastBean = $finder->getBean();
                if (!$lastBean->empty('CmsMenu_Order')) {
                    $order = $lastBean->get('CmsMenu_Order') + 1;
                }
            }
            $bean->set('CmsMenu_Order', $order);
        }
        parent::beforeSave($bean);
    }


    protected function translate(string $name): string
    {
        return $this->getTranslator()->translate($name, 'validation');
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('CmsMenuState_Code')) {
            $this->getValidationHelper()->addError('CmsMenuState_Code', $this->translate('articlestate.code.empty'));
        }
        if ($bean->empty('CmsMenuType_Code')) {
            $this->getValidationHelper()->addError('CmsMenuType_Code', $this->translate('articletype.code.empty'));
        }
        return parent::validateForSave($bean);
    }
}
