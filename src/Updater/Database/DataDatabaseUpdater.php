<?php

namespace Pars\Model\Updater\Database;

use Pars\Core\Database\Updater\AbstractDatabaseUpdater;
use Pars\Model\File\FileBeanFinder;
use Symfony\Component\Uid\Uuid;

/**
 * Class DataUpdater
 * @package Pars\Core\Database\Updater
 */
class DataDatabaseUpdater extends AbstractDatabaseUpdater
{

    public function getCode(): string
    {
        return 'data';
    }

    public function updateDataConfigType()
    {
        $data_Map = [];
        $data_Map[] = [
            'ConfigType_Code' => 'base',
            'ConfigType_Active' => 1,
        ];
        $data_Map[] = [
            'ConfigType_Code' => 'frontend',
            'ConfigType_Code_Parent' => 'base',
            'ConfigType_Active' => 1,
        ];
        $data_Map[] = [
            'ConfigType_Code' => 'admin',
            'ConfigType_Code_Parent' => 'base',
            'ConfigType_Active' => 1,
        ];
        $data_Map[] = [
            'ConfigType_Code' => 'style',
            'ConfigType_Active' => 1,
        ];
        return $this->saveDataMap('ConfigType', 'ConfigType_Code', $data_Map);
    }


    public function updateDataConfig()
    {
        $imageOptions = [];
        $fileFinder = new FileBeanFinder($this->adapter);
        foreach ($fileFinder->getBeanList() as $bean) {
            $filename = $bean->get('FileDirectory_Code') . '/' . $bean->get('File_Code') . '.' . $bean->get('FileType_Code');
            $imageOptions[] = $filename;
        }
        $i = 1;
        $data_Map = [];
        $data_Map[] = [
            'Config_Code' => 'asset.domain',
            'Config_Value' => isset($_SERVER['HTTP_HOST']) ?  $_SERVER['HTTP_HOST'] : '',
            'Config_Locked' => 0,
            'Config_Description' => 'cdn.example.com',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'domains',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'Config_Description' => 'example.com, example.de, example.it',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'translation.provider.libretranslate.enabled',
            'Config_Value' => 'true',
            'Config_Locked' => 0,
            'Config_Options' => ['true', 'false'],
            'Config_Description' => 'Libretranslate translation enabled',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'translation.provider.libretranslate.host',
            'Config_Value' => 'localhost:5000',
            'Config_Locked' => 0,
            'Config_Description' => 'Libretranslate translation server',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'secret',
            'Config_Value' => Uuid::v6(),
            'Config_Locked' => 1,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'salt',
            'Config_Value' => Uuid::v6(),
            'Config_Locked' => 1,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'uuid',
            'Config_Value' => Uuid::v6(),
            'Config_Locked' => 1,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'locale.default',
            'Config_Value' => 'de_AT',
            'Config_Options' => json_encode($this->getKeyList('Locale', 'Locale_Code')),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.timezone',
            'Config_Value' => 'UTC',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.title',
            'Config_Value' => 'PARS Admin',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.author',
            'Config_Value' => 'PARS',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.favicon',
            'Config_Value' => '/favicon.ico',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.description',
            'Config_Value' => 'PARS Admin',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.charset',
            'Config_Value' => 'utf-8',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'admin.pagination.limit',
            'Config_Value' => '20',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'admin',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp',
            'Config_Value' => 'false',
            'Config_Description' => 'true, false',
            'Config_Options' => json_encode(['true', 'false']),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'theme',
            'Config_Value' => 'dark',
            'Config_Description' => '',
            'Config_Options' => json_encode([
                'dark',
                'light',
                'darkblue',
                'lightblue',
                'darkgreen',
                'lightgreen',
                'darkred',
                'lightred',
                'darkorange',
                'lightorange',
            ]),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.name',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.host',
            'Config_Value' => '127.0.0.1',
            'Config_Description' => '127.0.0.1',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.port',
            'Config_Value' => '25',
            'Config_Description' => '25, 587',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.authentication',
            'Config_Value' => '',
            'Config_Description' => 'plain, login',
            'Config_Options' => json_encode(['plain', 'login']),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.authentication.username',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.authentication.password',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'mail.smtp.authentication.ssl',
            'Config_Value' => 'tls',
            'Config_Description' => 'tls, ssl',
            'Config_Options' => json_encode(['tls', 'ssl']),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.brand',
            'Config_Value' => '{frontend.brand}',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.domain',
            'Config_Value' => isset($_SERVER['HTTP_HOST']) ?  ltrim($_SERVER['HTTP_HOST'] ?? '', 'admin.') : '',
            'Config_Locked' => 0,
            'Config_Description' => 'example.com',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'api.domain',
            'Config_Value' => isset($_SERVER['HTTP_HOST']) ?  str_replace('admin', 'api', $_SERVER['HTTP_HOST'] ?? '', ) : '',
            'Config_Locked' => 0,
            'Config_Description' => 'api.example.com',
            'ConfigType_Code' => 'base',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.update',
            'Config_Value' => 'true',
            'Config_Locked' => 1,
            'ConfigType_Code' => 'frontend',
        ];
        $favicon = [
            'Config_Code' => 'frontend.favicon',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'Config_Options' => count($imageOptions) ? $imageOptions : '',
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = $favicon;
        $logo = [
            'Config_Code' => 'frontend.logo',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'Config_Options' => count($imageOptions) ? $imageOptions : '',
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = $logo;
        $data_Map[] = [
            'Config_Code' => 'frontend.color',
            'Config_Value' => '#FFFFFF',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.cache',
            'Config_Value' => '86400',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.charset',
            'Config_Value' => 'utf-8',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.author',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.keywords',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.timezone',
            'Config_Value' => 'UTC',
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.google-key',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'Config_Description' => 'Google Site Verification',
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.google-maps-key',
            'Config_Value' => '',
            'Config_Locked' => 0,
            'Config_Description' => 'Google Maps API-Key',
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.data-privacy-email',
            'Config_Value' => 'privacy@' . ltrim($_SERVER['HTTP_HOST'] ?? '', 'admin.'),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        $data_Map[] = [
            'Config_Code' => 'frontend.pars-api-key',
            'Config_Value' => 'de_AT',
            'Config_Options' => json_encode($this->getKeyList('ApiKey', 'ApiKey_Key')),
            'Config_Locked' => 0,
            'ConfigType_Code' => 'frontend',
        ];
        return $this->saveDataMap(
            'Config',
            ['Config_Code', 'ConfigType_Code'],
            $data_Map,
            true,
            [
                'Config_Description',
                'Config_Options',
                'ConfigType_Code',
                'Config_Locked'
            ]
        );
    }


    public function updateDataUserState()
    {
        $data_Map = [];
        $data_Map[] = [
            'UserState_Code' => 'active',
            'UserState_Active' => true,
        ];
        $data_Map[] = [
            'UserState_Code' => 'inactive',
            'UserState_Active' => true,
        ];
        $data_Map[] = [
            'UserState_Code' => 'locked',
            'UserState_Active' => true,
        ];
        return $this->saveDataMap('UserState', 'UserState_Code', $data_Map);
    }

    public function updateDataLocale()
    {
        $i = 1;
        $data_Map = [];
        $data_Map[] = [
            'Locale_Code' => 'de_AT',
            'Locale_UrlCode' => 'de-AT',
            'Locale_Name' => 'Deutsch (Österreich)',
            'Locale_Active' => 1,
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'de_DE',
            'Locale_UrlCode' => 'de-DE',
            'Locale_Name' => 'Deutsch (Deutschland)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'de_BE',
            'Locale_UrlCode' => 'de-BE',
            'Locale_Name' => 'Deutsch (Belgien)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'de_LI',
            'Locale_UrlCode' => 'de-LI',
            'Locale_Name' => 'Deutsch (Liechtenstein)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'de_LU',
            'Locale_UrlCode' => 'de-LU',
            'Locale_Name' => 'Deutsch (Luxembourg)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'de_CH',
            'Locale_UrlCode' => 'de-CH',
            'Locale_Name' => 'Deutsch (Schweiz)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'en_AU',
            'Locale_UrlCode' => 'en-AU',
            'Locale_Name' => 'English (Australia)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'en_BE',
            'Locale_UrlCode' => 'en-BE',
            'Locale_Name' => 'English (Belgium)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'en_US',
            'Locale_UrlCode' => 'en-US',
            'Locale_Name' => 'English (United States)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'en_GB',
            'Locale_UrlCode' => 'en-GB',
            'Locale_Name' => 'English (United Kingdom)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'nl_NL',
            'Locale_UrlCode' => 'nl-NL',
            'Locale_Name' => 'Dutch (Netherlands)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'sl_SI',
            'Locale_UrlCode' => 'sl-SI',
            'Locale_Name' => 'Slovenian (Slovenia)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'hu_HU',
            'Locale_UrlCode' => 'hu-HU',
            'Locale_Name' => 'Hungarian (Hungary)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'it_IT',
            'Locale_UrlCode' => 'it-IT',
            'Locale_Name' => 'Italian (Italy)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'it_SM',
            'Locale_UrlCode' => 'it-SM',
            'Locale_Name' => 'Italian (San Marino)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'it_CH',
            'Locale_UrlCode' => 'it-CH',
            'Locale_Name' => 'Italian (Switzerland)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'es_ES',
            'Locale_UrlCode' => 'es-ES',
            'Locale_Name' => 'Spanish (Spain)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'es_US',
            'Locale_UrlCode' => 'es-US',
            'Locale_Name' => 'Spanish (United States)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'fr_FR',
            'Locale_UrlCode' => 'fr-FR',
            'Locale_Name' => 'French (France)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'fr_BE',
            'Locale_UrlCode' => 'fr-BE',
            'Locale_Name' => 'French (Belgium)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'fr_LU',
            'Locale_UrlCode' => 'fr-LU',
            'Locale_Name' => 'French (Luxembourg)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'fr_MC',
            'Locale_UrlCode' => 'fr-MC',
            'Locale_Name' => 'French (Monaco)',
            'Locale_Order' => $i++,
        ];
        $data_Map[] = [
            'Locale_Code' => 'fr_CH',
            'Locale_UrlCode' => 'fr-CH',
            'Locale_Name' => 'French (Switzerland)',
            'Locale_Order' => $i++,
        ];
        return $this->saveDataMap('Locale', 'Locale_Code', $data_Map, true);
    }

    public function updateDataCmsPostState()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsPostState_Code' => 'active',
            'CmsPostState_Active' => true,
        ];
        $data_Map[] = [
            'CmsPostState_Code' => 'inactive',
            'CmsPostState_Active' => true,
        ];
        return $this->saveDataMap('CmsPostState', 'CmsPostState_Code', $data_Map);
    }


    public function updateDataCmsPostType()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsPostType_Code' => 'default',
            'CmsPostType_Template' => 'cmspost::default',
            'CmsPostType_Active' => 1,
        ];
        return $this->saveDataMap('CmsPostType', 'CmsPostType_Code', $data_Map);
    }

    public function updateDataCmsPageState()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsPageState_Code' => 'active',
            'CmsPageState_Active' => true,
        ];
        $data_Map[] = [
            'CmsPageState_Code' => 'inactive',
            'CmsPageState_Active' => true,
        ];
        return $this->saveDataMap('CmsPageState', 'CmsPageState_Code', $data_Map);
    }


    public function updateDataCmsPageType()
    {
        $i = 1;
        $data_Map = [];

        $data_Map[] = [
            'CmsPageType_Code' => 'default',
            'CmsPageType_Template' => 'cmspage::default',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsPageType_Code' => 'blog',
            'CmsPageType_Template' => 'cmspage::blog',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];
        $data_Map[] = [
            'CmsPageType_Code' => 'redirect',
            'CmsPageType_Template' => 'cmspage::redirect',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsPageType_Code' => 'tiles',
            'CmsPageType_Template' => 'cmspage::tiles',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];
        $data_Map[] = [
            'CmsPageType_Code' => 'columns',
            'CmsPageType_Template' => 'cmspage::columns',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsPageType_Code' => 'about',
            'CmsPageType_Template' => 'cmspage::about',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsPageType_Code' => 'faq',
            'CmsPageType_Template' => 'cmspage::faq',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];
        $data_Map[] = [
            'CmsPageType_Code' => 'gallery',
            'CmsPageType_Template' => 'cmspage::gallery',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];
        $data_Map[] = [
            'CmsPageType_Code' => 'tesla',
            'CmsPageType_Template' => 'cmspage::tesla',
            'CmsPageType_Active' => 1,
            'CmsPageType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsPageType_Code' => 'home',
            'CmsPageType_Template' => 'cmspage::home',
            'CmsPageType_Active' => 0,
            'CmsPageType_Order' => $i++,
        ];
        return $this->saveDataMap('CmsPageType', 'CmsPageType_Code', $data_Map);
    }


    public function updateDataCmsPageLayout()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsPageLayout_Code' => 'default',
            'CmsPageLayout_Template' => 'layout::default',
            'CmsPageLayout_Active' => 1,
        ];
        $data_Map[] = [
            'CmsPageLayout_Code' => 'narrow',
            'CmsPageLayout_Template' => 'layout::narrow',
            'CmsPageLayout_Active' => 1,
        ];
        return $this->saveDataMap('CmsPageLayout', 'CmsPageLayout_Code', $data_Map);
    }

    public function updateDataCmsBlockState()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsBlockState_Code' => 'active',
            'CmsBlockState_Active' => true,
        ];
        $data_Map[] = [
            'CmsBlockState_Code' => 'inactive',
            'CmsBlockState_Active' => true,
        ];
        return $this->saveDataMap('CmsBlockState', 'CmsBlockState_Code', $data_Map);
    }

    public function updateDataFileType()
    {
        $data_Map = [];
        $data_Map[] = [
            'FileType_Code' => 'jpg',
            'FileType_Mime' => 'image/jpeg',
            'FileType_Name' => 'JPEG',
            'FileType_Active' => true,
        ];
        $data_Map[] = [
            'FileType_Code' => 'png',
            'FileType_Mime' => 'image/png',
            'FileType_Name' => 'PNG',
            'FileType_Active' => true,
        ];
        return $this->saveDataMap('FileType', 'FileType_Code', $data_Map);
    }


    public function updateDataCmsBlockType()
    {
        $i = 1;
        $data_Map = [];
        $data_Map[] = [
            'CmsBlockType_Code' => 'default',
            'CmsBlockType_Template' => 'cmsblock::default',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'banner',
            'CmsBlockType_Template' => 'cmsblock::banner',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'tiles',
            'CmsBlockType_Template' => 'cmsblock::tiles',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'picture',
            'CmsBlockType_Template' => 'cmsblock::picture',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'video',
            'CmsBlockType_Template' => 'cmsblock::video',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'link',
            'CmsBlockType_Template' => 'cmsblock::link',
            'CmsBlockType_Active' => 1,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'text',
            'CmsBlockType_Template' => 'cmsblock::text',
            'CmsBlockType_Active' => 0,
            'CmsBlockType_Order' => $i++,
        ];

        $data_Map[] = [
            'CmsBlockType_Code' => 'contact',
            'CmsBlockType_Template' => 'cmsblock::contact',
            'CmsBlockType_Active' => 0,
            'CmsBlockType_Order' => $i++,
        ];
        $data_Map[] = [
            'CmsBlockType_Code' => 'poll',
            'CmsBlockType_Template' => 'cmsblock::poll',
            'CmsBlockType_Active' => 0,
            'CmsBlockType_Order' => $i++,
        ];




        return $this->saveDataMap('CmsBlockType', 'CmsBlockType_Code', $data_Map);
    }


    public function updateDataCmsMenuState()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsMenuState_Code' => 'active',
            'CmsMenuState_Active' => true,
        ];
        $data_Map[] = [
            'CmsMenuState_Code' => 'inactive',
            'CmsMenuState_Active' => true,
        ];
        return $this->saveDataMap('CmsMenuState', 'CmsMenuState_Code', $data_Map);
    }


    public function updateDataCmsMenuType()
    {
        $data_Map = [];
        $data_Map[] = [
            'CmsMenuType_Code' => 'header',
            'CmsMenuType_Template' => 'cmsmenu::header',
            'CmsMenuType_Active' => 1,
        ];
        $data_Map[] = [
            'CmsMenuType_Code' => 'footer',
            'CmsMenuType_Template' => 'cmsmenu::footer',
            'CmsMenuType_Active' => 1,
        ];
        $data_Map[] = [
            'CmsMenuType_Code' => 'aside_left',
            'CmsMenuType_Template' => 'cmsmenu::aside_left',
            'CmsMenuType_Active' => 1,
        ];
        $data_Map[] = [
            'CmsMenuType_Code' => 'aside_right',
            'CmsMenuType_Template' => 'cmsmenu::aside_right',
            'CmsMenuType_Active' => 1,
        ];
        return $this->saveDataMap('CmsMenuType', 'CmsMenuType_Code', $data_Map);
    }


    public function updateDataUserPermission()
    {
        $data_Map = [];

        $data_Map[] = [
            'UserPermission_Code' => 'content',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'media',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'system',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'article',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'article.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'article.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'article.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'config',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'config.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'config.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'config.edit',
            'UserPermission_Active' => true,
        ];


        $data_Map[] = [
            'UserPermission_Code' => 'cmsmenu',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsmenu.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsmenu.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsmenu.edit',
            'UserPermission_Active' => true,
        ];


        $data_Map[] = [
            'UserPermission_Code' => 'cmspage',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspage.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspage.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspage.edit',
            'UserPermission_Active' => true,
        ];


        $data_Map[] = [
            'UserPermission_Code' => 'cmspost',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspost.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspost.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspost.edit',
            'UserPermission_Active' => true,
        ];


        $data_Map[] = [
            'UserPermission_Code' => 'cmsblock',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsblock.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsblock.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmsblock.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'cmspageblock',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspageblock.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspageblock.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'cmspageblock.edit',
            'UserPermission_Active' => true,
        ];


        $data_Map[] = [
            'UserPermission_Code' => 'user',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'user.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'user.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'user.edit',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'user.edit.state',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'role',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'role.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'role.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'role.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'userrole',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'userrole.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'userrole.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'userrole.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'rolepermission',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'rolepermission.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'rolepermission.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'rolepermission.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'translation',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'translation.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'translation.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'translation.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'locale',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'locale.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'locale.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'locale.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'update',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'update.schema',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'update.data',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'update.special',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'file',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'file.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'file.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'file.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'filedirectory',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'filedirectory.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'filedirectory.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'filedirectory.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'form',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'form.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'form.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'form.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'import',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'import.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'import.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'import.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'apikey',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'apikey.delete',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'apikey.create',
            'UserPermission_Active' => true,
        ];
        $data_Map[] = [
            'UserPermission_Code' => 'apikey.edit',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'tasklog',
            'UserPermission_Active' => true,
        ];

        $data_Map[] = [
            'UserPermission_Code' => 'debug',
            'UserPermission_Active' => true,
        ];

        return $this->saveDataMap('UserPermission', 'UserPermission_Code', $data_Map);
    }

    /**
     * @return array
     */
    public function updateDataImportType()
    {
        $data_Map[] = [
            'ImportType_Code' => 'tesla',
            'ImportType_Active' => 1
        ];
        return $this->saveDataMap('ImportType', 'ImportType_Code', $data_Map);
    }

    public function updateDataArticleOption()
    {
        $data_Map = [];
        return $this->saveDataMap('ArticleOption', 'ArticleOption_Code', $data_Map);
    }

    public function updateFormType()
    {
        $data_Map = [];
        $i = 0;
        $data_Map[] = [
            'FormType_Code' => 'default',
            'FormType_Active' => 1,
            'FormType_Order' => ++$i,
        ];
        return $this->saveDataMap('FormType', 'FormType_Code', $data_Map);
    }

    public function updateFormFieldType()
    {
        $data_Map = [];
        $i = 0;
        $data_Map[] = [
            'FormFieldType_Code' => 'text',
            'FormFieldType_Active' => 1,
            'FormFieldType_Order' => ++$i,
        ];
        $data_Map[] = [
            'FormFieldType_Code' => 'checkbox',
            'FormFieldType_Active' => 1,
            'FormFieldType_Order' => ++$i,
        ];
        return $this->saveDataMap('FormFieldType', 'FormFieldType_Code', $data_Map);
    }
}
