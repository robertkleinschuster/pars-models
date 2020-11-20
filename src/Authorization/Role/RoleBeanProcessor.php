<?php

namespace Pars\Model\Authorization\Role;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class RoleBeanProcessor
 * @package Pars\Model\Authorization\Role
 */
class RoleBeanProcessor extends AbstractBeanProcessor implements
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
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole', 'UserRole_ID', true);
        $saver->addColumn('UserRole_Code', 'UserRole_Code', 'UserRole', 'UserRole_ID');
        $saver->addColumn('UserRole_Active', 'UserRole_Active', 'UserRole', 'UserRole_ID');

        parent::__construct($saver);
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

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('UserRole_Code')) {
            $this->getValidationHelper()->addError('UserRole_Code', $this->translate('userrole.code.empty'));
        }
        $finder = new RoleBeanFinder($this->adapter);
        $finder->setUserRole_Code($bean->get('UserRole_Code'));
        if (!$bean->empty('UserRole_ID')) {
            $finder->setUserRole_ID($bean->get('UserRole_ID'), true);
        }
        if ($finder->count() !== 0) {
            $this->getValidationHelper()->addError('UserRole_Code', $this->translate('userrole.code.unique'));
        }
        return !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
