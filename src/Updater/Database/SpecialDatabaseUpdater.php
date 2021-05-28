<?php

namespace Pars\Model\Updater\Database;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Ddl\Constraint\PrimaryKey;
use Laminas\Db\Sql\Ddl\DropTable;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Pars\Core\Database\Updater\AbstractDatabaseUpdater;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;
use Pars\Model\Authorization\Permission\PermissionBeanFinder;
use Pars\Model\Authorization\Role\RoleBeanFinder;
use Pars\Model\Authorization\Role\RoleBeanProcessor;
use Pars\Model\Authorization\RolePermission\RolePermissionBeanFinder;
use Pars\Model\Authorization\RolePermission\RolePermissionBeanProcessor;
use Pars\Model\Cms\Page\CmsPageBeanFinder;
use Pars\Model\Cms\Page\CmsPageBeanProcessor;
use Pars\Model\Form\Field\FormFieldBeanFinder;
use Pars\Model\Form\Field\FormFieldBeanProcessor;
use Pars\Model\Form\FormBeanFinder;
use Pars\Model\Form\FormBeanProcessor;
use Pars\Model\Picture\PictureBeanFinder;
use Pars\Model\Translation\TranslationLoader\TranslationBeanFinder;
use Pars\Model\Translation\TranslationLoader\TranslationBeanProcessor;
use Pars\Pattern\Exception\CoreException;

/**
 * Class SpecialUpdater
 * @package Pars\Model\Updater
 */
class SpecialDatabaseUpdater extends AbstractDatabaseUpdater
{
    public function getCode(): string
    {
        return 'special';
    }

    public function updateAdminPermissions()
    {
        $roleFinder = new RoleBeanFinder($this->adapter);
        $roleFinder->setUserRole_Code('admin');
        $role = $roleFinder->getBean();
        $permissionFinder = new PermissionBeanFinder($this->adapter);
        $permissionBeanList = $permissionFinder->getBeanList();
        $rolePermissionFinder = new RolePermissionBeanFinder($this->adapter);
        $rolePermissionFinder->setUserRole_ID($role->get('UserRole_ID'));
        $rolePermissionBeanList = $rolePermissionFinder->getBeanFactory()->getEmptyBeanList();
        $existingRolerPermissionBeanList = $rolePermissionFinder->getBeanList();
        $existing = $existingRolerPermissionBeanList->column('UserPermission_Code');
        foreach ($permissionBeanList as $permission) {
            if (!in_array($permission->get('UserPermission_Code'), $existing)) {
                $rolePermission = $rolePermissionFinder->getBeanFactory()->getEmptyBean([]);
                $rolePermission->set('UserRole_ID', $role->get('UserRole_ID'));
                $rolePermission->set('UserPermission_Code', $permission->get('UserPermission_Code'));
                $rolePermissionBeanList->push($rolePermission);
            }
        }
        $rolePermissionProcessor = new RolePermissionBeanProcessor($this->adapter);
        $rolePermissionProcessor->setBeanList($rolePermissionBeanList);
        if ($this->isExecute()) {
            $rolePermissionProcessor->save();
        }
        return 'New: ' . implode(', ', $rolePermissionBeanList->column('UserPermission_Code'));
    }


    public function updateRoleModerator()
    {
        return $this->role('moderator', 'Moderator', true);
    }

    public function updateModeratorPermissions()
    {
        $authorPermissions = [
            'content',
            'media',
            'article',
            'article.create',
            'article.edit',
            'article.delete',
            'cmsmenu',
            'cmsmenu.create',
            'cmsmenu.edit',
            'cmsmenu.delete',
            'cmspage',
            'cmspage.create',
            'cmspage.edit',
            'cmspage.delete',
            'cmspageblock',
            'cmspageblock.create',
            'cmspageblock.edit',
            'cmspageblock.delete',
            'cmsblock',
            'cmsblock.create',
            'cmsblock.edit',
            'cmsblock.delete',
            'cmspost',
            'cmspost.create',
            'cmspost.edit',
            'cmspost.delete',
            'file',
            'file.create',
            'file.edit',
            'file.delete',
            'filedirectory',
            'filedirectory.create',
            'filedirectory.edit',
            'filedirectory.delete',
        ];
        return $this->rolePermissions('moderator', $authorPermissions);
    }

    public function updateRoleAuthor()
    {
        return $this->role('author', 'Author', true);
    }

    public function updateAuthorPermissions()
    {
        $authorPermissions = [
            'content',
            'media',
            'article',
            'article.create',
            #  'article.edit',
            #  'article.delete',
            #  'cmsmenu',
            #  'cmsmenu.create',
            #  'cmsmenu.edit',
            #  'cmsmenu.delete',
            'cmspage',
            'cmspage.create',
            #  'cmspage.edit',
            #  'cmspage.delete',
            'cmspageblock',
            'cmspageblock.create',
            #  'cmspageblock.edit',
            #  'cmspageblock.delete',
            'cmsblock',
            'cmsblock.create',
            #  'cmsblock.edit',
            #  'cmsblock.delete',
            'cmspost',
            'cmspost.create',
            #  'cmspost.edit',
            #  'cmspost.delete',
            'file',
            'file.create',
            #  'file.edit',
            #  'file.delete',
            'filedirectory',
            'filedirectory.create',
            #  'filedirectory.edit',
            #  'filedirectory.delete',
        ];
        return $this->rolePermissions('author', $authorPermissions);
    }


    public function updateRoleBlogger()
    {
        return $this->role('blogger', 'Blogger', true);
    }

    public function updateBloggerPermissions()
    {
        $authorPermissions = [
            'content',
            #'media',
            'article',
            'article.create',
            #  'article.edit',
            #  'article.delete',
            #  'cmsmenu',
            #  'cmsmenu.create',
            #  'cmsmenu.edit',
            #  'cmsmenu.delete',
            'cmspage',
            #'cmspage.create',
            #  'cmspage.edit',
            #  'cmspage.delete',
            #'cmspageblock',
            #'cmspageblock.create',
            #  'cmspageblock.edit',
            #  'cmspageblock.delete',
            #'cmsblock',
            #'cmsblock.create',
            #  'cmsblock.edit',
            #  'cmsblock.delete',
            'cmspost',
            'cmspost.create',
            #  'cmspost.edit',
            #  'cmspost.delete',
            #'file',
            #'file.create',
            #  'file.edit',
            #  'file.delete',
            #'filedirectory',
            #'filedirectory.create',
            #  'filedirectory.edit',
            #  'filedirectory.delete',
        ];
        return $this->rolePermissions('blogger', $authorPermissions);
    }

    /**
     * @param string $code
     * @param string $name
     * @param bool $active
     * @return int|string
     */
    protected function role(string $code, string $name, bool $active)
    {
        $roleFinder = new RoleBeanFinder($this->adapter);
        $roleFinder->setUserRole_Code($code);
        if ($roleFinder->count() === 0) {
            $roleProcessor = new RoleBeanProcessor($this->adapter);
            $roleBean = $roleFinder->getBeanFactory()->getEmptyBean([]);
            $roleBeanList = $roleFinder->getBeanFactory()->getEmptyBeanList();
            $roleBean->set('UserRole_Code', $code);
            $roleBean->set('UserRole_Name', $name);
            $roleBean->set('UserRole_Active', $active);
            $roleBeanList->push($roleBean);
            $roleProcessor->setBeanList($roleBeanList);
            if ($this->getMode() == self::MODE_EXECUTE) {
                $roleProcessor->save();
            }
            return $roleBeanList->count();
        }
        return '';
    }

    /**
     * @param string $roleCode
     * @param array $permissions
     * @return string
     * @throws \Pars\Bean\Type\Base\BeanException
     */
    protected function rolePermissions(string $roleCode, array $permissions)
    {
        $roleFinder = new RoleBeanFinder($this->adapter);
        $roleFinder->setUserRole_Code($roleCode);
        if ($roleFinder->count() == 1) {
            $role = $roleFinder->getBean();
            $permissionFinder = new PermissionBeanFinder($this->adapter);
            $permissionBeanList = $permissionFinder->getBeanList();
            $rolePermissionFinder = new RolePermissionBeanFinder($this->adapter);
            $rolePermissionFinder->setUserRole_ID($role->get('UserRole_ID'));
            $rolePermissionBeanList = $rolePermissionFinder->getBeanFactory()->getEmptyBeanList();
            $rolePermissionBeanListDelete = $rolePermissionFinder->getBeanFactory()->getEmptyBeanList();
            $existingRolerPermissionBeanList = $rolePermissionFinder->getBeanList();
            $existing = $existingRolerPermissionBeanList->column('UserPermission_Code');
            foreach ($permissionBeanList as $permission) {
                $rolePermission = $rolePermissionFinder->getBeanFactory()->getEmptyBean([]);
                $rolePermission->set('UserRole_ID', $role->get('UserRole_ID'));
                $rolePermission->set('UserPermission_Code', $permission->get('UserPermission_Code'));
                if (
                    !in_array($permission->get('UserPermission_Code'), $existing)
                    && in_array($permission->get('UserPermission_Code'), $permissions)
                ) {
                    $rolePermissionBeanList->push($rolePermission);
                } elseif (
                    in_array($permission->get('UserPermission_Code'), $existing)
                    && !in_array($permission->get('UserPermission_Code'), $permissions)
                ) {
                    $rolePermissionBeanListDelete->push($rolePermission);
                }
            }
            $rolePermissionProcessor = new RolePermissionBeanProcessor($this->adapter);
            $rolePermissionProcessor->setBeanList($rolePermissionBeanList);
            if ($this->getMode() == self::MODE_EXECUTE) {
                $rolePermissionProcessor->save();
            }
            $rolePermissionProcessor = new RolePermissionBeanProcessor($this->adapter);
            $rolePermissionProcessor->setBeanList($rolePermissionBeanListDelete);
            if ($this->getMode() == self::MODE_EXECUTE) {
                $rolePermissionProcessor->delete();
            }
            return 'New: ' . implode(', ', $rolePermissionBeanList->column('UserPermission_Code'))
                . '<br>Delete: ' . implode(', ', $rolePermissionBeanListDelete->column('UserPermission_Code'));
        }
        return '';
    }

    public function updateTransferParagraphToBlock()
    {
        if (in_array('CmsParagraph', $this->existingTableList)) {
            $select = new Select('CmsParagraph');
            $sql = new Sql($this->adapter);
            $query = $sql->buildSqlString($select, $this->adapter);
            $selectResult = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
            if (is_iterable($selectResult)) {
                foreach ($selectResult as $item) {
                    $datum = [];
                    foreach ($item as $key => $value) {
                        $datum[str_replace('Paragraph', 'Block', $key)] = $value;
                    }
                    $select = new Select('CmsBlock');
                    $select->where($datum);
                    $sql = new Sql($this->adapter);
                    $query = $sql->buildSqlString($select, $this->adapter);
                    $countResult = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
                    if (!$countResult->count()) {
                        $insert = new Insert('CmsBlock');
                        $insert->values($datum);
                        $this->query($insert);
                    }
                }
            }
            $drop = new DropTable('CmsParagraph');
            return $this->query($drop);
        }
        return '';
    }

    public function updateTransferPageParagraphToPageBlock()
    {
        if (in_array('CmsPage_CmsParagraph', $this->existingTableList)) {
            $select = new Select('CmsPage_CmsParagraph');
            $sql = new Sql($this->adapter);
            $query = $sql->buildSqlString($select, $this->adapter);
            $selectResult = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
            if (is_iterable($selectResult)) {
                foreach ($selectResult as $item) {
                    $datum = [];
                    foreach ($item as $key => $value) {
                        $datum[str_replace('Paragraph', 'Block', $key)] = $value;
                    }
                    $select = new Select('CmsPage_CmsBlock');
                    $select->where($datum);
                    $sql = new Sql($this->adapter);
                    $query = $sql->buildSqlString($select, $this->adapter);
                    $countResult = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
                    if (!$countResult->count()) {
                        $insert = new Insert('CmsPage_CmsBlock');
                        $insert->values($datum);
                        $this->query($insert);
                    }
                }
            }
            $drop = new DropTable('CmsPage_CmsParagraph');
            return $this->query($drop);
        }
        return '';
    }

    public function updateDropCmsPagragraphType()
    {
        if (in_array('CmsParagraphType', $this->existingTableList)) {
            $drop = new DropTable('CmsParagraphType');
            return $this->query($drop);
        }
        return '';
    }

    public function updateDropCmsPagragraphState()
    {
        if (in_array('CmsParagraphState', $this->existingTableList)) {
            $drop = new DropTable('CmsParagraphState');
            return $this->query($drop);
        }
        return '';
    }

    public function updateConfigPK_Drop()
    {
        $keys = $this->metadata->getConstraintKeys('PRIMARY', 'Config', $this->adapter->getCurrentSchema());
        $key_List = [];
        foreach ($keys as $key) {
            $key_List[] = $key->getColumnName();
        }
        if (!in_array('ConfigType_Code', $key_List)) {
            $table = $this->getTableStatement('Config');
            $table->dropConstraint('PRIMARY');
            return $this->query($table);
        }
        return false;
    }

    public function updateConfigPK_Add()
    {
        $keys = $this->metadata->getConstraintKeys('PRIMARY', 'Config', $this->adapter->getCurrentSchema());
        $key_List = [];
        foreach ($keys as $key) {
            $key_List[] = $key->getColumnName();
        }
        if (!in_array('ConfigType_Code', $key_List)) {
            $table = $this->getTableStatement('Config');
            $constraint = new PrimaryKey(['Config_Code', 'ConfigType_Code']);
            $table->addConstraint($constraint);
            return $this->query($table);
        }
        return false;
    }

    public function updateDeleteArticleTranslationFile()
    {
        $finder = new ArticleTranslationBeanFinder($this->adapter, null, false);
        $beanListToSave = $finder->getBeanFactory()->getEmptyBeanList();
        foreach ($finder->getBeanListDecorator() as $bean) {
            if ($bean->isset('File_ID')) {
                $bean->set('File_ID', null);
                $beanListToSave->push($bean);
            }
        }
        $processor = new ArticleTranslationBeanProcessor($this->adapter);
        $processor->setBeanList($beanListToSave);
        if ($this->getMode() == self::MODE_EXECUTE) {
            $processor->save();
        }
        if ($processor->getValidationHelper()->hasError()) {
            throw new CoreException($processor->getValidationHelper()->getSummary());
        }
        return $beanListToSave->count();
    }

    public function updatePageBlock()
    {
        $delete = new Delete('CmsPage_CmsBlock');
        $delete->where('1 = 1');
        return $this->query($delete);
    }

    public function updateContactForm()
    {
        $formFinder = new FormBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $formFinder->filterValue('Form_Code', 'contact');
        if ($formFinder->count() == 0 && $this->getMode() == self::MODE_EXECUTE) {
            $bean = $formFinder->getBeanFactory()->getEmptyBean([]);
            $beanList = $formFinder->getBeanFactory()->getEmptyBeanList();
            $bean->Form_Code = 'contact';
            $bean->FormType_Code = 'default';
            $bean->Form_IndexInfo = true;
            $beanList->push($bean);
            $processor = new FormBeanProcessor($this->getParsContainer());
            $processor->setBeanList($beanList);
            $processor->save();

            $formFieldFinder = new FormFieldBeanFinder($this->adapter);
            $fieldBeanList = $formFieldFinder->getBeanFactory()->getEmptyBeanList();
            $fieldBean = $formFieldFinder->getBeanFactory()->getEmptyBean([]);
            $fieldBean->Form_ID = $bean->Form_ID;
            $fieldBean->FormField_Code = 'name';
            $fieldBean->FormField_Required = true;
            $fieldBean->FormField_Order = 1;
            $fieldBean->FormFieldType_Code = 'text';
            $fieldBeanList->push($fieldBean);

            $fieldBean = $formFieldFinder->getBeanFactory()->getEmptyBean([]);
            $fieldBean->Form_ID = $bean->Form_ID;
            $fieldBean->FormField_Code = 'email';
            $fieldBean->FormField_Required = true;
            $fieldBean->FormField_Order = 2;
            $fieldBean->FormFieldType_Code = 'text';
            $fieldBeanList->push($fieldBean);


            $fieldBean = $formFieldFinder->getBeanFactory()->getEmptyBean([]);
            $fieldBean->Form_ID = $bean->Form_ID;
            $fieldBean->FormField_Code = 'message';
            $fieldBean->FormField_Required = false;
            $fieldBean->FormField_Order = 3;
            $fieldBean->FormFieldType_Code = 'textarea';
            $fieldBeanList->push($fieldBean);

            $fieldBean = $formFieldFinder->getBeanFactory()->getEmptyBean([]);
            $fieldBean->Form_ID = $bean->Form_ID;
            $fieldBean->FormField_Code = 'data-privacy';
            $fieldBean->FormField_Required = true;
            $fieldBean->FormField_Order = 4;
            $fieldBean->FormFieldType_Code = 'checkbox';
            $fieldBeanList->push($fieldBean);

            $fieldProcessor = new FormFieldBeanProcessor($this->getParsContainer());
            $fieldProcessor->setBeanList($fieldBeanList);
            return $fieldProcessor->save();
        }
        return 0;
    }

    public function updateStartpage()
    {
        $finder = new CmsPageBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $finder->filterValue('Article_Code', 'startpage');
        if ($finder->count() == 0 && $this->isExecute()) {
            $factory = $finder->getBeanFactory();
            $bean = $factory->getEmptyBean([]);
            $bean->CmsPageType_Code = 'default';
            $bean->CmsPageLayout_Code = 'default';
            $bean->CmsPageState_Code = 'active';
            $bean->Article_Code = 'startpage';
            $bean->ArticleTranslation_Code = '/';
            $bean->ArticleTranslation_Name = 'Home';
            $bean->ArticleTranslation_Title = 'Home';
            $bean->ArticleTranslation_Heading = 'Home';
            $bean->Locale_Code = $this->getParsContainer()->getConfig()->get('locale.default');
            $beanList = $factory->getEmptyBeanList();
            $beanList->push($bean);
            $processor = new CmsPageBeanProcessor($this->getParsContainer()->getDatabaseAdapter()->getDbAdapter());
            $processor->setBeanList($beanList);
            return $processor->save();
        }
        return null;
    }

    /*  public function updateBenchmarkBackend()
      {
          ini_set('max_execution_time', 300);
          $finder = new TranslationBeanFinder($this->adapter);
          $beanList = $finder->getBeanFactory()->getEmptyBeanList();
          for ($i  = 0; $i < 10000; $i++) {
              $bean = $finder->getBeanFactory()->getEmptyBean([]);
              $bean->Locale_Code = 'de_AT';
              $bean->Translation_Code = 'Benchmark ' . $i;
              $bean->Translation_Text = 'Benchmark ' . $i;
              $bean->Translation_Namespace = 'benchmark';
              $finder->filterTranslation_Code($bean->Translation_Code);
              if ($finder->count() === 0) {
                  $beanList->push($bean);
              }
          }

          $processor = new TranslationBeanProcessor($this->adapter);
          $processor->setBeanList($beanList);
          if ($this->getMode() == self::MODE_EXECUTE) {
              $processor->save();
          }
          return $beanList->count();
      }*/
}
