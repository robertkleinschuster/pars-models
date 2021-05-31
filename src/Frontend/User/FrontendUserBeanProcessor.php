<?php


namespace Pars\Model\Frontend\User;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class FrontendUserBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('Person.Person_ID')->addTable('FrontendUser')->setKey(true);
        $saver->addField('Person.Person_Firstname');
        $saver->addField('Person.Person_Lastname');
        $saver->addField('FrontendUser.FrontendUser_Username');
        $saver->addField('FrontendUser.FrontendUesr_Password');
    }

    protected function initValidator()
    {
        $this->addSaveValidatorFunction('validateFrontendUser_Username');
    }

    protected function validateFrontendUser_Username(FrontendUserBean $bean)
    {
        $result = false;
        $finder = new FrontendUserBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $finder->filterValue('FrontendUser_Username', $bean->FrontendUser_Username);
        if ($bean->Person_ID) {
            $finder->excludeValue('Person_ID', $bean->Person_ID);
        }
        if ($finder->count()) {
            $this->getValidationHelper()->addError(
                'FrontendUser_Username',
                $this->translateValidation('frontenduser.username.unique')
            );
        } else {
            $result = true;
        }
        return $result;
    }

}
