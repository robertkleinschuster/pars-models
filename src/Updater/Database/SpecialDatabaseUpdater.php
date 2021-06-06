<?php

namespace Pars\Model\Updater\Database;

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
use Pars\Model\File\Directory\FileDirectoryBeanFinder;
use Pars\Model\File\Directory\FileDirectoryBeanProcessor;
use Pars\Model\Form\Field\FormFieldBeanFinder;
use Pars\Model\Form\Field\FormFieldBeanProcessor;
use Pars\Model\Form\FormBeanFinder;
use Pars\Model\Form\FormBeanProcessor;
use Pars\Model\Picture\PictureBeanFinder;
use Pars\Model\Picture\PictureBeanProcessor;
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
        $roleFinder = new RoleBeanFinder($this->getDatabaseAdapter());
        $roleFinder->setUserRole_Code($code);
        if ($roleFinder->count() === 0) {
            $roleProcessor = new RoleBeanProcessor($this->getDatabaseAdapter());
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
        $roleFinder = new RoleBeanFinder($this->getDatabaseAdapter());
        $roleFinder->setUserRole_Code($roleCode);
        if ($roleFinder->count() == 1) {
            $role = $roleFinder->getBean();
            $permissionFinder = new PermissionBeanFinder($this->getDatabaseAdapter());
            $permissionBeanList = $permissionFinder->getBeanList();
            $rolePermissionFinder = new RolePermissionBeanFinder($this->getDatabaseAdapter());
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
            $rolePermissionProcessor = new RolePermissionBeanProcessor($this->getDatabaseAdapter());
            $rolePermissionProcessor->setBeanList($rolePermissionBeanList);
            if ($this->getMode() == self::MODE_EXECUTE) {
                $rolePermissionProcessor->save();
            }
            $rolePermissionProcessor = new RolePermissionBeanProcessor($this->getDatabaseAdapter());
            $rolePermissionProcessor->setBeanList($rolePermissionBeanListDelete);
            if ($this->getMode() == self::MODE_EXECUTE) {
                $rolePermissionProcessor->delete();
            }
            return 'New: ' . implode(', ', $rolePermissionBeanList->column('UserPermission_Code'))
                . '<br>Delete: ' . implode(', ', $rolePermissionBeanListDelete->column('UserPermission_Code'));
        }
        return '';
    }

    public function updateDeleteArticleTranslationFile()
    {
        $finder = new ArticleTranslationBeanFinder($this->getDatabaseAdapter(), false);
        $beanListToSave = $finder->getBeanFactory()->getEmptyBeanList();
        foreach ($finder->getBeanListDecorator() as $bean) {
            if ($bean->isset('File_ID')) {
                $bean->set('File_ID', null);
                $beanListToSave->push($bean);
            }
        }
        $processor = new ArticleTranslationBeanProcessor($this->getDatabaseAdapter());
        $processor->setBeanList($beanListToSave);
        if ($this->getMode() == self::MODE_EXECUTE) {
            $processor->save();
        }
        if ($processor->getValidationHelper()->hasError()) {
            throw new CoreException($processor->getValidationHelper()->getSummary());
        }
        return $beanListToSave->count();
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
            $processor = new FormBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
            $processor->setBeanList($beanList);
            $processor->save();

            $formFieldFinder = new FormFieldBeanFinder($this->getParsContainer()->getDatabaseAdapter());
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

            $fieldProcessor = new FormFieldBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
            $fieldProcessor->setBeanList($fieldBeanList);
            return $fieldProcessor->save();
        }
        return 0;
    }


    public function updateImagesFileDirectory()
    {
        $finder = new FileDirectoryBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $finder->filterValue('FileDirectory_Code', 'images');
        if ($finder->count() == 0) {
            $factory = $finder->getBeanFactory();
            $bean = $factory->getEmptyBean([]);
            $bean->FileDirectory_Code = 'images';
            $bean->FileDirectory_Active = true;
            $bean->FileDirectory_Name = 'images';
            $beanList = $factory->getEmptyBeanList();
            $beanList->push($bean);

            $processor = new FileDirectoryBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
            $processor->setBeanList($beanList);
            $processor->save();
        }
    }

    public function updateStartpagePicture()
    {
        $finder = new FileDirectoryBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $finder->filterValue('FileDirectory_Code', 'images');
        if ($finder->count() == 1) {
            $fileDirectory_ID = $finder->getBean()->FileDirectory_ID;
            $finder = new PictureBeanFinder($this->getParsContainer()->getDatabaseAdapter());
            $finder->filterValue('File_Code', 'startpage');
            if ($finder->count() == 0) {
                $factory = $finder->getBeanFactory();
                $bean = $factory->getEmptyBean([]);
                $bean->FileDirectory_ID = $fileDirectory_ID;
                $bean->File_Code = 'startpage';
                $bean->File_Name = 'startpage';
                $bean->FileType_Code = 'jpg';
                $beanList = $factory->getEmptyBeanList();
                $beanList->push($bean);
                $processor = new PictureBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
                $processor->addOption(PictureBeanProcessor::OPTION_IGNORE_VALIDATION);
                $processor->setBeanList($beanList);
                $processor->save();
            }
        }
    }

    public function updateStartpage()
    {
        $finder = new CmsPageBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $processor = new CmsPageBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
        $data = [
            'CmsPageType_Code' => 'default',
            'CmsPageLayout_Code' => 'default',
            'CmsPageState_Code' => 'active',
            'Article_Code' => 'startpage',
            'ArticleTranslation_Code' => '/',
            'ArticleTranslation_Name' => 'Home',
            'ArticleTranslation_Title' => 'Home',
            'ArticleTranslation_Heading' => 'Home',
            'ArticleTranslation_Text' => '{picture:startpage:inline}{form:contact}',
            'Locale_Code' => $this->getLocaleDefault(),
        ];
        return $this->saveBeanData($finder, $processor, 'Article_Code', $data);
    }



    public function updateDataPrivacy()
    {
        $finder = new CmsPageBeanFinder($this->getParsContainer()->getDatabaseAdapter());
        $processor = new CmsPageBeanProcessor($this->getParsContainer()->getDatabaseAdapter());
        $data = [
            'CmsPageType_Code' => 'default',
            'CmsPageLayout_Code' => 'default',
            'CmsPageState_Code' => 'active',
            'Article_Code' => 'data-privacy',
            'ArticleTranslation_Code' => 'data-privacy',
            'ArticleTranslation_Name' => 'data-privacy',
            'ArticleTranslation_Title' => 'data-privacy',
            'ArticleTranslation_Heading' => 'data-privacy',
            'Locale_Code' => $this->getLocaleDefault(),
        ];

        $page = json_decode(file_get_contents(__DIR__ . '/page_data-privacy.json'), true);

        if (isset($page[$data['Locale_Code']])) {
            $data['ArticleTranslation_Text'] = $page[$data['Locale_Code']]['ArticleTranslation_Text'];
            $data['ArticleTranslation_Title'] = $page[$data['Locale_Code']]['ArticleTranslation_Title'];
            $data['ArticleTranslation_Name'] = $page[$data['Locale_Code']]['ArticleTranslation_Name'];
            $data['ArticleTranslation_Heading'] = $page[$data['Locale_Code']]['ArticleTranslation_Heading'];
            $data['ArticleTranslation_Code'] = $page[$data['Locale_Code']]['ArticleTranslation_Code'];

            if (is_array($page[$data['Locale_Code']]['CmsBlock_BeanList'])) {
                foreach ($page[$data['Locale_Code']]['CmsBlock_BeanList'] as $paragraph) {
                    if (is_array($paragraph)) {
                        $data['ArticleTranslation_Text'] .= "<h4>{$paragraph['ArticleTranslation_Heading']}</h4>";
                        $data['ArticleTranslation_Text'] .= $paragraph['ArticleTranslation_Text'];
                    }
                }
            }
        }
        return $this->saveBeanData($finder, $processor, 'Article_Code', $data);
    }


    /*public function updateBenchmarkBackend()
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
