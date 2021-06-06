<?php

namespace Pars\Model\Updater\Database;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table;
use Pars\Core\Database\Updater\AbstractDatabaseUpdater;
use Pars\Helper\String\StringHelper;

/**
 * Class SchemaUpdater
 * @package Pars\Model\Updater
 */
class SchemaDatabaseUpdater extends AbstractDatabaseUpdater
{

    protected const TYPE_VARCHAR = 'string';
    protected const TYPE_BOOLEAN = 'boolean';
    protected const TYPE_INTEGER = 'integer';
    protected const TYPE_TEXT = 'text';
    protected const TYPE_JSON = 'json';
    protected const TYPE_TIMESTAMP = 'timestamp';

    public function getCode(): string
    {
        return 'schema';
    }

    public function getSchemaManager()
    {
        return $this->getDatabaseAdapter()->getSchemaManager();
    }

    protected function getSchema()
    {
        static $schema = null;
        if (null === $schema) {
            $schema = clone $this->getSchemaManager()->createSchema();
        }
        return $schema;
    }

    protected function getCurrentSchema(bool $update = false)
    {
        static $schema = null;
        if (null === $schema) {
            $schema = $this->getSchemaManager()->createSchema();
        }

        $result = clone $schema;
        if ($update) {
            $schema = $this->getSchemaManager()->createSchema();
        }
        return $result;
    }

    protected function getPlatform()
    {
        return $this->getDatabaseAdapter()->getConnection()->getDatabasePlatform();
    }

    protected function getTableStatement(string $tableName)
    {
        if ($this->getSchema()->hasTable($tableName)) {
            $table = $this->getSchema()->getTable($tableName);
        } else {
            $table = $this->getSchema()->createTable($tableName);
        }
        return $table;
    }


    protected function initAsTypeTable(Table $table)
    {
        $tableName = $table->getName();
        $this->addColumnToTable($table, "{$tableName}_Code");
        $this->addColumnToTable($table, "{$tableName}_Template");
        $this->addColumnToTable($table, "{$tableName}_Active");
        $this->addColumnToTable($table, "{$tableName}_Order");
        $this->addPrimaryKeyToTable($table, "{$tableName}_Code");
        $this->addDefaultColumnsToTable($table);
    }

    protected function initAsStateTable(Table $table)
    {
        $tableName = $table->getName();
        $this->addColumnToTable($table, "{$tableName}_Code");
        $this->addColumnToTable($table, "{$tableName}_Active");
        $this->addColumnToTable($table, "{$tableName}_Order");
        $this->addPrimaryKeyToTable($table, "{$tableName}_Code");
        $this->addDefaultColumnsToTable($table);
    }

    protected function addColumnToTable(Table $table, string $name, string $type = null, bool $nullable = null, bool $deleteCascade = false)
    {
        $default = 0;

        if (null === $type) {
            if (StringHelper::endsWith($name, '_Order')) {
                $type = self::TYPE_INTEGER;
                $default = 0;
            }
            if (StringHelper::endsWith($name, '_Name')) {
                $type = self::TYPE_VARCHAR;
            }

            if (StringHelper::endsWith($name, '_Template')) {
                $type = self::TYPE_VARCHAR;
            }
            if (StringHelper::endsWith($name, '_Active')) {
                $type = self::TYPE_BOOLEAN;
                $default = 1;
            }
            if (StringHelper::endsWith($name, '_Code')) {
                $type = self::TYPE_VARCHAR;
                $exp = explode('_', $name);
                $foreignTable = reset($exp);
                if ($table->getName() !== $foreignTable) {
                    $this->addForeignKeyToTable($table, $foreignTable, $name, null, $deleteCascade);
                }
            }

            if (StringHelper::endsWith($name, '_Data')) {
                $type = self::TYPE_JSON;
                if (null === $nullable) {
                    $nullable = true;
                }
            }
            if (StringHelper::endsWith($name, '_Text')) {
                $type = self::TYPE_TEXT;
                if (null === $nullable) {
                    $nullable = true;
                }
            }
            if (StringHelper::endsWith($name, '_ID')) {
                $type = self::TYPE_INTEGER;
                $exp = explode('_', $name);
                $foreignTable = reset($exp);
                if ($table->getName() !== $foreignTable) {
                    $this->addForeignKeyToTable($table, $foreignTable, $name, null, $deleteCascade);
                }
            }
        }

        if ($table->hasColumn($name)) {
            $column = $table->getColumn($name);
        } else {
            $column = $table->addColumn($name, $type);
        }
        if (in_array($type, ['text', 'json'])) {
            $column->setLength(65535);
        }
        if (in_array($type, ['varchar'])) {
            $column->setLength(255);
        }
        if (in_array($type, ['boolean'])) {
            $column->setDefault($default);
        }
        if (in_array($type, ['timestamp'])) {
            $column->setDefault('CURRENT_TIMESTAMP');
        }
        if (StringHelper::endsWith($name, '_Order')) {
            $column->setDefault(0);
        }
        $column->setNotnull(!$nullable);

        if ($name === $table->getName() . '_ID') {
            $column->setAutoincrement(true);
            $this->addPrimaryKeyToTable($table, $name);
        }
        return $column;
    }

    protected function addPrimaryKeyToTable(Table $table, $key)
    {
        if (!is_array($key)) {
            $key = [$key];
        }
        if (!$table->hasPrimaryKey()) {
            $table->setPrimaryKey($key);
        }
    }

    protected function addUniqueKeyToTable(Table $table, $key)
    {
        if (!is_array($key)) {
            $key = [$key];
        }
        $table->addUniqueConstraint($key);
    }

    protected function addIndexToTable(Table $table, $key)
    {
        if (!is_array($key)) {
            $key = [$key];
        }
        try {
            $table->addIndex($key);
        } catch (SchemaException $schemaException) {

        }
    }

    protected function addDefaultColumnsToTable(Table $table)
    {
        $this->addColumnToTable($table, 'Timestamp_Create', 'timestamp')
            ->setNotnull(false)->setDefault('CURRENT_TIMESTAMP');
        $this->addColumnToTable($table, 'Person_ID_Create', 'integer')
            ->setNotnull(false);
        $this->addColumnToTable($table, 'Timestamp_Edit', 'timestamp')
            ->setNotnull(false)->setDefault('CURRENT_TIMESTAMP');
        $this->addColumnToTable($table, 'Person_ID_Edit', 'integer')
            ->setNotnull(false);
        $this->addForeignKeyToTable($table, 'Person', 'Person_ID_Create', 'Person_ID');
        $this->addForeignKeyToTable($table, 'Person', 'Person_ID_Edit', 'Person_ID');
    }

    protected function addForeignKeyToTable(Table $table, string $foreignTable, string $localColumn, string $foreignColumn = null, bool $deleteCascade = false)
    {
        if (null === $foreignColumn) {
            $foreignColumn = $localColumn;
        }
        $options = [];
        if ($deleteCascade) {
            $options['onDelete'] = 'CASCADE';
        }
        $table->addForeignKeyConstraint($foreignTable, [$localColumn], [$foreignColumn], $options);
    }


    public function updateTablePerson()
    {
        $table = $this->getTableStatement('Person');
        $this->addColumnToTable($table, 'Person_ID', 'integer')
            ->setAutoincrement(true);
        $this->addColumnToTable($table, 'Person_Firstname', 'varchar')
            ->setLength(255)->setNotnull(false);
        $this->addColumnToTable($table, 'Person_Lastname', 'varchar')
            ->setLength(255)->setNotnull(false);
        $this->addPrimaryKeyToTable($table, 'Person_ID');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableTaskLog()
    {
        $table = $this->getTableStatement('TaskLog');
        $this->addColumnToTable($table, 'TaskLog_ID', 'integer')
            ->setAutoincrement(true);
        $this->addColumnToTable($table, 'TaskLog_Message', 'varchar')
            ->setLength('255')->setNotnull(false);
        $this->addColumnToTable($table, 'TaskLog_Text', 'text')
            ->setLength(65535)->setNotnull(false);
        $this->addColumnToTable($table, 'TaskLog_Data', 'json')
            ->setLength('65535')->setNotnull(false);
        $this->addDefaultColumnsToTable($table);
        $this->addPrimaryKeyToTable($table, 'TaskLog_ID');
        return $this->updateSchema();
    }


    public function updateTableConfigType()
    {
        $table = $this->getTableStatement('ConfigType');
        $this->addColumnToTable($table, 'ConfigType_Code', 'varchar')
            ->setLength(255);
        $this->addColumnToTable($table, 'ConfigType_Code_Parent', 'varchar', true)
            ->setLength(255);
        $this->addColumnToTable($table, 'ConfigType_Active', 'boolean')
            ->setDefault(0);
        $this->addColumnToTable($table, 'ConfigType_Order', 'integer')
            ->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'ConfigType_Code');
        $this->addForeignKeyToTable($table, 'ConfigType', 'ConfigType_Code_Parent', 'ConfigType_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableConfig()
    {
        $table = $this->getTableStatement('Config');
        $this->addColumnToTable($table,
            'Config_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'Config_Value',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'Config_Description',
            'varchar',
            true
        )->setLength(255);

        $this->addColumnToTable($table,
            'Config_Options',
            'text',
            true)
            ->setLength(65535);
        $this->addColumnToTable($table,
            'Config_Locked',
            'boolean')
            ->setDefault(0);
        $this->addColumnToTable($table,
            'Config_Data',
            'json',
            true)
            ->setLength(65535);

        $this->addColumnToTable($table,
            'ConfigType_Code',
            'varchar')
            ->setLength(255);
        $this->addPrimaryKeyToTable($table, ['Config_Code', 'ConfigType_Code']);
        $this->addForeignKeyToTable($table, 'ConfigType', 'ConfigType_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableFileType()
    {
        $table = $this->getTableStatement('FileType');
        $this->addColumnToTable($table,
            'FileType_Code',
            'varchar')
            ->setLength(255);
        $this->addColumnToTable($table,
            'FileType_Mime',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'FileType_Name',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'FileType_Active',
            'boolean')
            ->setDefault(0);

        $this->addColumnToTable($table,
            'FileType_Order',
            'integer')
            ->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'FileType_Code');
        #$this->addUniqueKeyToTable($table, 'FileType_Mime');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableFileDirectory()
    {
        $table = $this->getTableStatement('FileDirectory');
        $this->addColumnToTable($table,
            'FileDirectory_ID',
            'integer')
            ->setAutoincrement(true);

        $this->addColumnToTable($table,
            'FileDirectory_Code',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'FileDirectory_Name',
            'varchar')
            ->setLength(255);
        $this->addColumnToTable($table,
            'FileDirectory_Active',
            'boolean')
            ->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'FileDirectory_ID');
        $this->addUniqueKeyToTable($table, 'FileDirectory_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableFile()
    {
        $table = $this->getTableStatement('File');
        $this->addColumnToTable($table,
            'File_ID',
            'integer')
            ->setAutoincrement(true);

        $this->addColumnToTable($table,
            'FileType_Code',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'FileDirectory_ID',
            'integer', true);
        $this->addColumnToTable($table,
            'File_Name',
            'varchar')
            ->setLength(255);
        $this->addColumnToTable($table,
            'File_Code',
            'varchar')
            ->setLength(255);
        $this->addPrimaryKeyToTable($table, 'File_ID');
        $this->addForeignKeyToTable($table, 'FileDirectory', 'FileDirectory_ID', null, true);
        $this->addForeignKeyToTable($table, 'FileType', 'FileType_Code');
        $this->addUniqueKeyToTable($table, ['File_Code', 'FileDirectory_ID']);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTablePicture()
    {
        $table = $this->getTableStatement('Picture');
        $this->addColumnToTable($table,
            'Picture_ID',
            'integer')
            ->setAutoincrement(true);

        $this->addColumnToTable($table,
            'File_ID',
            'integer');
        $this->addPrimaryKeyToTable($table, 'Picture_ID');
        $this->addForeignKeyToTable($table, 'File', 'File_ID', null, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableLocale()
    {
        $table = $this->getTableStatement('Locale');
        $this->addColumnToTable($table,
            'Locale_Code',
            'varchar')->setLength(255);

        $this->addColumnToTable($table,
            'Locale_UrlCode',
            'varchar')
            ->setLength(255);

        $this->addColumnToTable($table,
            'Locale_Domain',
            'varchar', true)
            ->setLength(255);
        $this->addColumnToTable($table,
            'Locale_Name',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'Locale_Active',
            'boolean')->setDefault(0);
        $this->addColumnToTable($table,
            'Locale_Order',
            'integer')->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'Locale_Code');
        $this->addUniqueKeyToTable($table, 'Locale_UrlCode');
        $this->addIndexToTable($table, 'Locale_Domain');
        $this->addIndexToTable($table, 'Locale_Active');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableUserState()
    {
        $table = $this->getTableStatement('UserState');
        $this->addColumnToTable($table,
            'UserState_Code',
            'varchar')->setLength(255);

        $this->addColumnToTable($table,
            'UserState_Active',
            'boolean')->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'UserState_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableUser()
    {
        $table = $this->getTableStatement('User');
        $this->addColumnToTable($table,
            'Person_ID',
            'integer');
        $this->addColumnToTable($table,
            'UserState_Code',
            'varchar')->setLength(255);

        $this->addColumnToTable($table,
            'User_Username',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'User_Displayname',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'User_Password',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'User_LastLogin',
            'timestamp',
            true);
        $this->addColumnToTable($table,
            'Locale_Code',
            'varchar')
            ->setLength(255);
        $this->addPrimaryKeyToTable($table, 'Person_ID');
        $this->addForeignKeyToTable($table, 'Person', 'Person_ID', null, true);
        $this->addForeignKeyToTable($table, 'UserState', 'UserState_Code');
        $this->addForeignKeyToTable($table, 'Locale', 'Locale_Code');
        $this->addUniqueKeyToTable($table, 'User_Username');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableUserRole()
    {
        $table = $this->getTableStatement('UserRole');
        $this->addColumnToTable($table,
            'UserRole_ID',
            'integer')
            ->setAutoincrement(true);
        $this->addColumnToTable($table,
            'UserRole_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'UserRole_Name',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'UserRole_Active',
            'boolean')->setDefault(1);
        $this->addColumnToTable($table,
            'UserRole_Order',
            'integer')->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'UserRole_ID');
        $this->addUniqueKeyToTable($table, 'UserRole_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableUser_UserRole()
    {
        $table = $this->getTableStatement('User_UserRole');
        $this->addColumnToTable($table,
            'Person_ID',
            'integer');
        $this->addColumnToTable($table,
            'UserRole_ID',
            'integer');
        $this->addPrimaryKeyToTable($table, ['Person_ID', 'UserRole_ID']);
        $this->addForeignKeyToTable($table, 'Person', 'Person_ID', null, true);
        $this->addForeignKeyToTable($table, 'UserRole', 'UserRole_ID', null, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableUserPermission()
    {
        $table = $this->getTableStatement('UserPermission');
        $this->addColumnToTable($table,
            'UserPermission_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'UserPermission_Active',
            'boolean')->setDefault(1);
        $this->addColumnToTable($table,
            'UserPermission_Order',
            'integer')->setDefault(0);
        $this->addPrimaryKeyToTable($table, 'UserPermission_Code');
        $this->addPrimaryKeyToTable($table, 'UserPermission_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableUserRole_UserPermission()
    {
        $table = $this->getTableStatement('UserRole_UserPermission');
        $this->addColumnToTable($table,
            'UserRole_ID',
            'integer');

        $this->addColumnToTable($table,
            'UserPermission_Code',
            'varchar')->setLength(255);
        $this->addPrimaryKeyToTable($table, ['UserRole_ID', 'UserPermission_Code']);
        $this->addForeignKeyToTable($table, 'UserRole', 'UserRole_ID', null, true);
        $this->addForeignKeyToTable($table, 'UserPermission', 'UserPermission_Code', null, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableTranslation()
    {
        $table = $this->getTableStatement('Translation');
        $this->addColumnToTable($table,
            'Translation_ID',
            'integer')->setAutoincrement(true);

        $this->addColumnToTable($table,
            'Translation_Code',
            'varchar')->setLength(255);


        $this->addColumnToTable($table,
            'Locale_Code',
            'varchar')->setLength(255);

        $this->addColumnToTable($table,
            'Translation_Namespace',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'Translation_Text',
            'text', true)->setLength(65535);
        $this->addPrimaryKeyToTable($table, 'Translation_ID');
        $this->addForeignKeyToTable($table, 'Locale', 'Locale_Code');
        $this->addUniqueKeyToTable($table, ['Translation_Code', 'Locale_Code', 'Translation_Namespace']);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableArticle()
    {
        $table = $this->getTableStatement('Article');
        $this->addColumnToTable($table,
            'Article_ID',
            'integer')->setAutoincrement(true);

        $this->addColumnToTable($table,
            'Article_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'Article_Data',
            'json', true)->setLength(65535);
        $this->addPrimaryKeyToTable($table, 'Article_ID');
        $this->addUniqueKeyToTable($table, 'Article_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableArticleOption()
    {
        $table = $this->getTableStatement('ArticleOption');
        $this->addColumnToTable($table,
            'ArticleOption_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'ArticleOption_Active',
            'boolean')->setDefault(1);
        $this->addColumnToTable($table,
            'ArticleOption_Visible',
            'boolean')->setDefault(1);
        $this->addColumnToTable($table,
            'ArticleOption_Data',
            'json', true)->setLength(65535);
        $this->addPrimaryKeyToTable($table, 'ArticleOption_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableArticle_ArticleOption()
    {
        $table = $this->getTableStatement('Article_ArticleOption');
        $this->addColumnToTable($table,
            'Article_ID', 'integer');
        $this->addColumnToTable($table,
            'ArticleOption_Code',
            'varchar')->setLength(255);
        $this->addColumnToTable($table,
            'Article_ArticleOption_Data',
            'json', true)->setLength(65535);

        $this->addPrimaryKeyToTable($table, ['Article_ID', 'ArticleOption_Code']);
        $this->addForeignKeyToTable($table, 'Article', 'Article_ID', null, true);
        $this->addForeignKeyToTable($table, 'ArticleOption', 'ArticleOption_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableArticleData()
    {
        $table = $this->getTableStatement('ArticleData');
        $this->addColumnToTable($table,
            'ArticleData_ID',
            'integer')->setAutoincrement(true);
        $this->addColumnToTable($table,
            'Article_ID',
            'integer');
        $this->addColumnToTable($table,
            'ArticleData_Data',
            'json', true)->setLength(65535);
        $this->addColumnToTable($table,
            'ArticleData_Active',
            'boolean');
        $this->addColumnToTable($table,
            'ArticleData_Timestamp',
            'timestamp', true);
        $this->addPrimaryKeyToTable($table, 'ArticleData_ID');
        $this->addForeignKeyToTable($table, 'Article', 'Article_ID', null, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableArticleTranslation()
    {
        $table = $this->getTableStatement('ArticleTranslation');
        $this->addColumnToTable($table,
            'Article_ID', 'integer');
        $this->addColumnToTable($table,
            'Locale_Code', self::TYPE_VARCHAR);
        $this->addColumnToTable($table,
            'ArticleTranslation_Code', self::TYPE_VARCHAR);
        $this->addColumnToTable($table,
            'ArticleTranslation_Host', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table,
            'ArticleTranslation_Active', self::TYPE_BOOLEAN)->setDefault(1);
        $this->addColumnToTable($table,
            'ArticleTranslation_Name', self::TYPE_VARCHAR);
        $this->addColumnToTable($table, 'ArticleTranslation_Title', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Keywords', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Heading', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ArticleTranslation_SubHeading', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Path', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Teaser', self::TYPE_TEXT, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Text', self::TYPE_TEXT, true);
        $this->addColumnToTable($table, 'ArticleTranslation_Footer', self::TYPE_TEXT, true);
        $this->addPrimaryKeyToTable($table, ['Article_ID', 'Locale_Code']);
        $this->addForeignKeyToTable($table, 'Article', 'Article_ID', null, true);
        $this->addForeignKeyToTable($table, 'Locale', 'Locale_Code');
        $this->addIndexToTable($table, 'ArticleTranslation_Host');
        $this->addIndexToTable($table, 'ArticleTranslation_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableArticle_Picture()
    {
        $table = $this->getTableStatement('Article_Picture');
        $this->addColumnToTable($table,
            'Article_ID',
            self::TYPE_INTEGER);
        $this->addColumnToTable($table,
            'Picture_ID', self::TYPE_INTEGER);
        $this->addColumnToTable($table,
            'Article_Picture_Order', self::TYPE_INTEGER)->setDefault(0);
        $this->addPrimaryKeyToTable($table, ['Article_ID', 'Picture_ID']);
        $this->addForeignKeyToTable($table, 'Article', 'Article_ID');
        $this->addForeignKeyToTable($table, 'Picture', 'Picture_ID', null, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsMenuState()
    {
        $table = $this->getTableStatement('CmsMenuState');
        $this->initAsStateTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsMenuType()
    {
        $table = $this->getTableStatement('CmsMenuType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPageState()
    {
        $table = $this->getTableStatement('CmsPageState');
        $this->initAsStateTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPageType()
    {
        $table = $this->getTableStatement('CmsPageType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsPageLayout()
    {
        $table = $this->getTableStatement('CmsPageLayout');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsBlockState()
    {
        $table = $this->getTableStatement('CmsBlockState');
        $this->initAsStateTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsBlockType()
    {
        $table = $this->getTableStatement('CmsBlockType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsPostState()
    {
        $table = $this->getTableStatement('CmsPostState');
        $this->initAsStateTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPostType()
    {
        $table = $this->getTableStatement('CmsPostType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPage()
    {
        $table = $this->getTableStatement('CmsPage');
        $this->addColumnToTable($table, 'CmsPage_ID');
        $this->addColumnToTable($table, 'Article_ID');
        $this->addColumnToTable($table, 'CmsPageState_Code');
        $this->addColumnToTable($table, 'CmsPageType_Code');
        $this->addColumnToTable($table, 'CmsPageLayout_Code');
        $this->addColumnToTable($table, 'CmsPage_ID_Redirect', self::TYPE_INTEGER, true);
        $this->addPrimaryKeyToTable($table, 'CmsPage_ID');
        $this->addForeignKeyToTable($table, 'CmsPage', 'CmsPage_ID_Redirect', 'CmsPage_ID');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsBlock()
    {
        $table = $this->getTableStatement('CmsBlock');
        $this->addColumnToTable($table, 'CmsBlock_ID');
        $this->addColumnToTable($table, 'CmsBlock_ID_Parent', self::TYPE_INTEGER, true);
        $this->addColumnToTable($table, 'CmsBlock_Order', null, true);
        $this->addColumnToTable($table, 'Article_ID');
        $this->addColumnToTable($table, 'CmsBlockState_Code');
        $this->addColumnToTable($table, 'CmsBlockType_Code');
        $this->addForeignKeyToTable($table, 'CmsBlock', 'CmsBlock_ID_Parent', 'CmsBlock_ID', true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPage_CmsBlock()
    {
        $table = $this->getTableStatement('CmsPage_CmsBlock');
        $this->addColumnToTable($table, 'CmsPage_ID', null, null, true);
        $this->addColumnToTable($table, 'CmsBlock_ID', null, null, true);
        $this->addColumnToTable($table, 'CmsPage_CmsBlock_Order');
        $this->addPrimaryKeyToTable($table, ['CmsPage_ID', 'CmsBlock_ID']);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableCmsPost()
    {
        $table = $this->getTableStatement('CmsPost');
        $this->addColumnToTable($table, 'CmsPost_ID');
        $this->addColumnToTable($table, 'CmsPage_ID', null, null, true);
        $this->addColumnToTable($table, 'Article_ID', null, null, true);
        $this->addColumnToTable($table, 'CmsPost_PublishTimestamp', self::TYPE_TIMESTAMP);
        $this->addColumnToTable($table, 'CmsPostState_Code');
        $this->addColumnToTable($table, 'CmsPostType_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableCmsMenu()
    {
        $table = $this->getTableStatement('CmsMenu');
        $this->addColumnToTable($table, 'CmsMenu_ID');
        $this->addColumnToTable($table, 'CmsMenu_ID_Parent', self::TYPE_INTEGER, true);
        $this->addColumnToTable($table, 'CmsPage_ID', null, true, true);
        $this->addColumnToTable($table, 'CmsPage_ID_Parent', self::TYPE_INTEGER, true);
        $this->addColumnToTable($table, 'CmsMenu_Order');
        $this->addColumnToTable($table, 'CmsMenu_Level', self::TYPE_INTEGER, true)->setDefault(1);
        $this->addColumnToTable($table, 'CmsMenu_Name', null, true);
        $this->addColumnToTable($table, 'CmsMenuState_Code');
        $this->addColumnToTable($table, 'CmsMenuType_Code', null, true);
        $this->addForeignKeyToTable($table, 'CmsPage', 'CmsPage_ID', 'CmsPage_ID', true);
        $this->addForeignKeyToTable($table, 'CmsPage', 'CmsPage_ID_Parent', 'CmsPage_ID', true);
        $this->addForeignKeyToTable($table, 'CmsMenu', 'CmsMenu_ID_Parent', 'CmsMenu_ID', true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableImportType()
    {
        $table = $this->getTableStatement('ImportType');
        $this->initAsTypeTable($table);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableImport()
    {
        $table = $this->getTableStatement('Import');
        $this->addColumnToTable($table, 'Import_ID');
        $this->addColumnToTable($table, 'Article_ID', null, true);
        $this->addColumnToTable($table, 'ImportType_Code');
        $this->addColumnToTable($table, 'Import_Name');
        $this->addColumnToTable($table, 'Import_Data');
        $this->addColumnToTable($table, 'Import_Active');
        $this->addColumnToTable($table, 'Import_Day', self::TYPE_INTEGER, true);
        $this->addColumnToTable($table, 'Import_Hour', self::TYPE_INTEGER, true);
        $this->addColumnToTable($table, 'Import_Minute', self::TYPE_INTEGER, true);
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableApiKey()
    {
        $table = $this->getTableStatement('ApiKey');
        $this->addColumnToTable($table, 'ApiKey_ID');
        $this->addColumnToTable($table, 'ApiKey_Name', null, true);
        $this->addColumnToTable($table, 'ApiKey_Key', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ApiKey_Host', self::TYPE_VARCHAR, true);
        $this->addColumnToTable($table, 'ApiKey_Active');
        $this->addIndexToTable($table, 'ApiKey_Host');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableFormType()
    {
        $table = $this->getTableStatement('FormType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }


    public function updateTableForm()
    {
        $table = $this->getTableStatement('Form');
        $this->addColumnToTable($table, 'Form_ID');
        $this->addColumnToTable($table, 'FormType_Code');
        $this->addColumnToTable($table, 'Form_Code');
        $this->addColumnToTable($table, 'Form_SendEmail', self::TYPE_BOOLEAN);
        $this->addColumnToTable($table, 'Form_IndexInfo', self::TYPE_BOOLEAN);
        $this->addUniqueKeyToTable($table, 'Form_Code');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableFormData()
    {
        $table = $this->getTableStatement('FormData');
        $this->addColumnToTable($table, 'FormData_ID');
        $this->addColumnToTable($table, 'Form_ID');
        $this->addColumnToTable($table, 'FormData_Read', self::TYPE_BOOLEAN);
        $this->addColumnToTable($table, 'FormData_Data');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableFormFieldType()
    {
        $table = $this->getTableStatement('FormFieldType');
        $this->initAsTypeTable($table);
        return $this->updateSchema();
    }

    public function updateTableFormField()
    {
        $table = $this->getTableStatement('FormField');
        $this->addColumnToTable($table, 'FormField_ID');
        $this->addColumnToTable($table, 'Form_ID');
        $this->addColumnToTable($table, 'FormFieldType_Code');
        $this->addColumnToTable($table, 'FormField_Required', self::TYPE_BOOLEAN);
        $this->addColumnToTable($table, 'FormField_Code');
        $this->addColumnToTable($table, 'FormField_Order');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }


    public function updateTableFrontendUser()
    {
        $table = $this->getTableStatement('FrontendUser');
        $this->addColumnToTable($table, 'Person_ID');
        $this->addColumnToTable($table, 'FrontendUser_Username', self::TYPE_VARCHAR);
        $this->addColumnToTable($table, 'FrontendUser_Password', self::TYPE_VARCHAR);
        $this->addPrimaryKeyToTable($table, 'Person_ID');
        $this->addUniqueKeyToTable($table, 'FrontendUser_Username');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }

    public function updateTableFrontendStatistic()
    {
        $table = $this->getTableStatement('FrontendStatistic');
        $this->addColumnToTable($table, 'FrontendStatistic_ID');
        $this->addColumnToTable($table, 'FrontendStatistic_Group', self::TYPE_VARCHAR);
        $this->addColumnToTable($table, 'FrontendStatistic_Reference', self::TYPE_VARCHAR);
        $this->addColumnToTable($table, 'FrontendStatistic_Locale', self::TYPE_VARCHAR);
        $this->addColumnToTable($table, 'FrontendStatistic_Data');
        $this->addIndexToTable($table, 'FrontendStatistic_Group');
        $this->addIndexToTable($table, 'FrontendStatistic_Reference');
        $this->addIndexToTable($table, 'FrontendStatistic_Locale');
        $this->addDefaultColumnsToTable($table);
        return $this->updateSchema();
    }
}
