create table if not exists Person
(
    Person_ID        int auto_increment
        primary key,
    Person_Firstname varchar(255)                        null,
    Person_Lastname  varchar(255)                        null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint FrgKPrsnPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKPrsnPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ApiKey
(
    ApiKey_ID        int auto_increment
        primary key,
    ApiKey_Name      varchar(255)                         null,
    ApiKey_Name2     varchar(255)                         null,
    ApiKey_Key       varchar(255)                         null,
    ApiKey_Host      varchar(255)                         null,
    ApiKey_Active    tinyint(1) default 0                 not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    constraint FrgKApKPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKApKPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FrontendStatistic
(
    FrontendStatistic_ID        int auto_increment
        primary key,
    FrontendStatistic_Group     varchar(255)                        not null,
    FrontendStatistic_Reference varchar(255)                        not null,
    Timestamp_Create            timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create            int                                 null,
    Timestamp_Edit              timestamp default current_timestamp not null,
    Person_ID_Edit              int                                 null,
    constraint FrgKFndStcPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFndStcPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create or replace index IndFrntnSttstFrntnSttstGrp
    on FrontendStatistic (FrontendStatistic_Group);

create or replace index IndFrntnSttstFrntnSttstRfrnc
    on FrontendStatistic (FrontendStatistic_Reference);

create table if not exists Article
(
    Article_ID       int auto_increment
        primary key,
    Article_Code     varchar(255)                        null,
    Article_Data     mediumtext                          null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint UnqKArtclArtclCd
        unique (Article_Code),
    constraint FrgKArtclPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ArticleData
(
    ArticleData_ID        int auto_increment
        primary key,
    Article_ID            int                                  not null,
    ArticleData_Data      mediumtext                           null,
    ArticleData_Active    tinyint(1) default 1                 not null,
    ArticleData_Timestamp timestamp  default current_timestamp not null on update current_timestamp,
    Timestamp_Create      timestamp  default current_timestamp not null,
    Person_ID_Create      int                                  null,
    Timestamp_Edit        timestamp  default current_timestamp not null,
    Person_ID_Edit        int                                  null,
    constraint FrgKArtclDtArtclID
        foreign key (Article_ID) references Article (Article_ID)
            on delete cascade,
    constraint FrgKArtclDtPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclDtPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ArticleOption
(
    ArticleOption_Code    varchar(255)                         not null
        primary key,
    ArticleOption_Active  tinyint(1) default 1                 not null,
    ArticleOption_Visible tinyint(1) default 1                 not null,
    ArticleOption_Data    mediumtext                           null,
    Timestamp_Create      timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                  null,
    Timestamp_Edit        timestamp  default current_timestamp not null,
    Person_ID_Edit        int                                  null,
    constraint FrgKArtclOptnPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclOptnPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Article_ArticleOption
(
    Article_ID                 int                                 not null,
    ArticleOption_Code         varchar(255)                        not null,
    Article_ArticleOption_Data mediumtext                          null,
    Timestamp_Create           timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create           int                                 null,
    Timestamp_Edit             timestamp default current_timestamp not null,
    Person_ID_Edit             int                                 null,
    primary key (Article_ID, ArticleOption_Code),
    constraint FrgKArtclArtclOptnArtclID
        foreign key (Article_ID) references Article (Article_ID)
            on delete cascade,
    constraint FrgKArtclArtclOptnArtclOptnCd
        foreign key (ArticleOption_Code) references ArticleOption (ArticleOption_Code),
    constraint FrgKArtclArtclOptnPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclArtclOptnPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsBlockState
(
    CmsBlockState_Code   varchar(255)                         not null
        primary key,
    CmsBlockState_Active tinyint(1) default 1                 not null,
    Timestamp_Create     timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                  null,
    Timestamp_Edit       timestamp  default current_timestamp not null,
    Person_ID_Edit       int                                  null,
    CmsBlockState_Order  int        default 0                 not null,
    constraint FrgKCmsBlckSttPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsBlckSttPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsBlockType
(
    CmsBlockType_Code     varchar(255)                         not null
        primary key,
    CmsBlockType_Template varchar(255)                         not null,
    CmsBlockType_Active   tinyint(1) default 1                 not null,
    Timestamp_Create      timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                  null,
    Timestamp_Edit        timestamp  default current_timestamp not null,
    Person_ID_Edit        int                                  null,
    CmsBlockType_Order    int        default 0                 not null,
    constraint FrgKCmsBlckTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsBlckTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsBlock
(
    CmsBlock_ID        int auto_increment
        primary key,
    CmsBlock_ID_Parent int                                 null,
    CmsBlock_Order     int                                 null,
    Article_ID         int                                 not null,
    CmsBlockState_Code varchar(255)                        not null,
    CmsBlockType_Code  varchar(255)                        not null,
    Timestamp_Create   timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create   int                                 null,
    Timestamp_Edit     timestamp default current_timestamp not null,
    Person_ID_Edit     int                                 null,
    constraint FrgKCmsBlckArtclID
        foreign key (Article_ID) references Article (Article_ID),
    constraint FrgKCmsBlckCmsBlckIDPrnt
        foreign key (CmsBlock_ID_Parent) references CmsBlock (CmsBlock_ID)
            on delete cascade,
    constraint FrgKCmsBlckCmsBlckSttCd
        foreign key (CmsBlockState_Code) references CmsBlockState (CmsBlockState_Code),
    constraint FrgKCmsBlckCmsBlckTpCd
        foreign key (CmsBlockType_Code) references CmsBlockType (CmsBlockType_Code),
    constraint FrgKCmsBlckPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsBlckPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsMenuState
(
    CmsMenuState_Code   varchar(255)                         not null
        primary key,
    CmsMenuState_Active tinyint(1) default 1                 not null,
    Timestamp_Create    timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create    int                                  null,
    Timestamp_Edit      timestamp  default current_timestamp not null,
    Person_ID_Edit      int                                  null,
    CmsMenuState_Order  int        default 0                 not null,
    constraint FrgKCmsMnSttPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsMnSttPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsMenuType
(
    CmsMenuType_Code     varchar(255)                         not null
        primary key,
    CmsMenuType_Template varchar(255)                         not null,
    CmsMenuType_Active   tinyint(1) default 1                 not null,
    Timestamp_Create     timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                  null,
    Timestamp_Edit       timestamp  default current_timestamp not null,
    Person_ID_Edit       int                                  null,
    CmsMenuType_Order    int        default 0                 not null,
    constraint FrgKCmsMnTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsMnTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPageLayout
(
    CmsPageLayout_Code     varchar(255)                         not null
        primary key,
    CmsPageLayout_Template varchar(255)                         not null,
    CmsPageLayout_Active   tinyint(1) default 1                 not null,
    Timestamp_Create       timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create       int                                  null,
    Timestamp_Edit         timestamp  default current_timestamp not null,
    Person_ID_Edit         int                                  null,
    CmsPageLayout_Order    tinyint(1) default 0                 not null,
    constraint FrgKCmsPgLtPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPgLtPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPageState
(
    CmsPageState_Code   varchar(255)                         not null
        primary key,
    CmsPageState_Active tinyint(1) default 1                 not null,
    Timestamp_Create    timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create    int                                  null,
    Timestamp_Edit      timestamp  default current_timestamp not null,
    Person_ID_Edit      int                                  null,
    CmsPageState_Order  int        default 0                 not null,
    constraint FrgKCmsPgSttPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPgSttPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPageType
(
    CmsPageType_Code     varchar(255)                         not null
        primary key,
    CmsPageType_Template varchar(255)                         not null,
    CmsPageType_Active   tinyint(1) default 1                 not null,
    Timestamp_Create     timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                  null,
    Timestamp_Edit       timestamp  default current_timestamp not null,
    Person_ID_Edit       int                                  null,
    CmsPageType_Order    int        default 0                 not null,
    constraint FrgKCmsPgTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPgTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPage
(
    CmsPage_ID          int auto_increment
        primary key,
    Article_ID          int                                    not null,
    CmsPageState_Code   varchar(255)                           not null,
    CmsPageType_Code    varchar(255)                           not null,
    CmsPageLayout_Code  varchar(255) default 'default'         not null,
    CmsPage_ID_Redirect int                                    null,
    Timestamp_Create    timestamp    default current_timestamp not null on update current_timestamp,
    Person_ID_Create    int                                    null,
    Timestamp_Edit      timestamp    default current_timestamp not null,
    Person_ID_Edit      int                                    null,
    constraint FrgKCmsPgArtclID
        foreign key (Article_ID) references Article (Article_ID),
    constraint FrgKCmsPgCmsPgIDRdrct
        foreign key (CmsPage_ID_Redirect) references CmsPage (CmsPage_ID),
    constraint FrgKCmsPgCmsPgLtCd
        foreign key (CmsPageLayout_Code) references CmsPageLayout (CmsPageLayout_Code),
    constraint FrgKCmsPgCmsPgSttCd
        foreign key (CmsPageState_Code) references CmsPageState (CmsPageState_Code),
    constraint FrgKCmsPgCmsPgTpCd
        foreign key (CmsPageType_Code) references CmsPageType (CmsPageType_Code),
    constraint FrgKCmsPgPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPgPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsMenu
(
    CmsMenu_ID        int auto_increment
        primary key,
    CmsMenu_ID_Parent int                                 null,
    CmsPage_ID        int                                 null,
    CmsPage_ID_Parent int                                 null,
    CmsMenu_Order     int       default 0                 not null,
    CmsMenuState_Code varchar(255)                        not null,
    CmsMenuType_Code  varchar(255)                        null,
    Timestamp_Create  timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create  int                                 null,
    Timestamp_Edit    timestamp default current_timestamp not null,
    Person_ID_Edit    int                                 null,
    CmsMenu_Name      varchar(255)                        null,
    CmsMenu_Level     int       default 1                 null,
    constraint FrgKCmsMnCmsMnIDPrnt
        foreign key (CmsMenu_ID_Parent) references CmsMenu (CmsMenu_ID)
            on delete cascade,
    constraint FrgKCmsMnCmsMnSttCd
        foreign key (CmsMenuState_Code) references CmsMenuState (CmsMenuState_Code),
    constraint FrgKCmsMnCmsMnTpCd
        foreign key (CmsMenuType_Code) references CmsMenuType (CmsMenuType_Code),
    constraint FrgKCmsMnCmsPgID
        foreign key (CmsPage_ID) references CmsPage (CmsPage_ID)
            on delete cascade,
    constraint FrgKCmsMnCmsPgIDPrnt
        foreign key (CmsPage_ID_Parent) references CmsPage (CmsPage_ID)
            on delete cascade,
    constraint FrgKCmsMnPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsMnPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPage_CmsBlock
(
    CmsPage_ID             int                                 not null,
    CmsBlock_ID            int                                 not null,
    CmsPage_CmsBlock_Order int                                 not null,
    Timestamp_Create       timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create       int                                 null,
    Timestamp_Edit         timestamp default current_timestamp not null,
    Person_ID_Edit         int                                 null,
    primary key (CmsPage_ID, CmsBlock_ID),
    constraint FrgKCmsPgCmsBlckCmsBlckID
        foreign key (CmsBlock_ID) references CmsBlock (CmsBlock_ID)
            on delete cascade,
    constraint FrgKCmsPgCmsBlckCmsPgID
        foreign key (CmsPage_ID) references CmsPage (CmsPage_ID)
            on delete cascade,
    constraint FrgKCmsPgCmsBlckPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPgCmsBlckPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPostState
(
    CmsPostState_Code   varchar(255)                         not null
        primary key,
    CmsPostState_Active tinyint(1) default 1                 not null,
    Timestamp_Create    timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create    int                                  null,
    Timestamp_Edit      timestamp  default current_timestamp not null,
    Person_ID_Edit      int                                  null,
    CmsPostState_Order  int        default 0                 not null,
    constraint FrgKCmsPstSttPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPstSttPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPostType
(
    CmsPostType_Code     varchar(255)                         not null
        primary key,
    CmsPostType_Template varchar(255)                         not null,
    CmsPostType_Active   tinyint(1) default 1                 not null,
    Timestamp_Create     timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                  null,
    Timestamp_Edit       timestamp  default current_timestamp not null,
    Person_ID_Edit       int                                  null,
    CmsPostType_Order    int        default 0                 not null,
    constraint FrgKCmsPstTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPstTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists CmsPost
(
    CmsPost_ID               int auto_increment
        primary key,
    CmsPage_ID               int                                 not null,
    Article_ID               int                                 not null,
    CmsPost_PublishTimestamp timestamp default current_timestamp not null on update current_timestamp,
    CmsPostState_Code        varchar(255)                        not null,
    CmsPostType_Code         varchar(255)                        not null,
    Timestamp_Create         timestamp default current_timestamp not null,
    Person_ID_Create         int                                 null,
    Timestamp_Edit           timestamp default current_timestamp not null,
    Person_ID_Edit           int                                 null,
    constraint FrgKCmsPstArtclID
        foreign key (Article_ID) references Article (Article_ID)
            on delete cascade,
    constraint FrgKCmsPstCmsPgID
        foreign key (CmsPage_ID) references CmsPage (CmsPage_ID)
            on delete cascade,
    constraint FrgKCmsPstCmsPstSttCd
        foreign key (CmsPostState_Code) references CmsPostState (CmsPostState_Code),
    constraint FrgKCmsPstCmsPstTpCd
        foreign key (CmsPostType_Code) references CmsPostType (CmsPostType_Code),
    constraint FrgKCmsPstPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCmsPstPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ConfigType
(
    ConfigType_Code        varchar(255)                         not null
        primary key,
    ConfigType_Code_Parent varchar(255)                         null,
    ConfigType_Active      tinyint(1) default 0                 not null,
    Timestamp_Create       timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create       int                                  null,
    Timestamp_Edit         timestamp  default current_timestamp not null,
    Person_ID_Edit         int                                  null,
    ConfigType_Order       int        default 0                 not null,
    constraint FrgKCnfgTpCnfgTpCdPrnt
        foreign key (ConfigType_Code_Parent) references ConfigType (ConfigType_Code),
    constraint FrgKCnfgTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCnfgTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Config
(
    Config_Code        varchar(255)                         not null,
    Config_Value       varchar(255)                         null,
    Config_Description varchar(255)                         null,
    Config_Options     mediumtext                           null,
    Config_Locked      tinyint(1) default 0                 not null,
    Config_Data        mediumtext                           null,
    ConfigType_Code    varchar(255)                         not null,
    Timestamp_Create   timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create   int                                  null,
    Timestamp_Edit     timestamp  default current_timestamp not null,
    Person_ID_Edit     int                                  null,
    primary key (Config_Code, ConfigType_Code),
    constraint FrgKCnfgCnfgTpCd
        foreign key (ConfigType_Code) references ConfigType (ConfigType_Code),
    constraint FrgKCnfgPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKCnfgPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FileDirectory
(
    FileDirectory_ID     int auto_increment
        primary key,
    FileDirectory_Code   varchar(255)                        not null,
    FileDirectory_Name   varchar(255)                        not null,
    FileDirectory_Active tinyint(1)                          not null,
    Timestamp_Create     timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                 null,
    Timestamp_Edit       timestamp default current_timestamp not null,
    Person_ID_Edit       int                                 null,
    constraint UnqKFlDrctrFlDrctrCd
        unique (FileDirectory_Code),
    constraint FrgKFlDrctrPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFlDrctrPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FileType
(
    FileType_Code    varchar(255)                        not null
        primary key,
    FileType_Mime    varchar(255)                        not null,
    FileType_Name    varchar(255)                        not null,
    FileType_Active  tinyint(1)                          not null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    FileType_Order   int       default 0                 not null,
    constraint UnqKFlTpFlTpMm
        unique (FileType_Mime),
    constraint FrgKFlTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFlTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists File
(
    File_ID          int auto_increment
        primary key,
    FileType_Code    varchar(255)                        not null,
    FileDirectory_ID int                                 null,
    File_Name        varchar(255)                        not null,
    File_Code        varchar(255)                        not null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint UnqKFlFlCdFlDrctrID
        unique (File_Code, FileDirectory_ID),
    constraint FrgKFlFlDrctrID
        foreign key (FileDirectory_ID) references FileDirectory (FileDirectory_ID)
            on delete cascade,
    constraint FrgKFlFlTpCd
        foreign key (FileType_Code) references FileType (FileType_Code),
    constraint FrgKFlPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFlPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FormFieldType
(
    FormFieldType_Code   varchar(255)                         not null
        primary key,
    FormFieldType_Active tinyint(1) default 1                 not null,
    FormFieldType_Order  int        default 0                 not null,
    Timestamp_Create     timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create     int                                  null,
    Timestamp_Edit       timestamp  default current_timestamp not null,
    Person_ID_Edit       int                                  null,
    constraint FrgKFrmFldTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrmFldTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FormType
(
    FormType_Code    varchar(255)                         not null
        primary key,
    FormType_Active  tinyint(1) default 1                 not null,
    FormType_Order   int        default 0                 not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    constraint FrgKFrmTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrmTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Form
(
    Form_ID          int auto_increment
        primary key,
    Form_Code        varchar(255)                         not null,
    FormType_Code    varchar(255)                         not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    Form_SendEmail   tinyint(1) default 0                 not null,
    Form_IndexInfo   tinyint(1) default 0                 not null,
    constraint UnqKFrmFrmCd
        unique (Form_Code),
    constraint FrgKFrmFrmTpCd
        foreign key (FormType_Code) references FormType (FormType_Code),
    constraint FrgKFrmPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrmPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FormData
(
    FormData_ID      int auto_increment
        primary key,
    Form_ID          int                                  not null,
    FormData_Data    mediumtext                           not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    FormData_Read    tinyint(1) default 0                 not null,
    constraint FrgKFrmDtFrmID
        foreign key (Form_ID) references Form (Form_ID)
            on delete cascade,
    constraint FrgKFrmDtPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrmDtPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FormField
(
    FormField_ID       int auto_increment
        primary key,
    Form_ID            int                                  not null,
    FormFieldType_Code varchar(255)                         not null,
    FormField_Required tinyint(1) default 0                 not null,
    FormField_Code     varchar(255)                         not null,
    Timestamp_Create   timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create   int                                  null,
    Timestamp_Edit     timestamp  default current_timestamp not null,
    Person_ID_Edit     int                                  null,
    FormField_Order    int        default 0                 not null,
    constraint UnqKFrmFldFrmFldCd
        unique (FormField_Code),
    constraint FrgKFrmFldFrmFldTpCd
        foreign key (FormFieldType_Code) references FormFieldType (FormFieldType_Code),
    constraint FrgKFrmFldFrmID
        foreign key (Form_ID) references Form (Form_ID)
            on delete cascade,
    constraint FrgKFrmFldPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrmFldPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists FrontendUser
(
    Person_ID             int                                 not null
        primary key,
    FrontendUser_Username varchar(255)                        not null,
    FrontendUser_Password varchar(255)                        not null,
    Timestamp_Create      timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                 null,
    Timestamp_Edit        timestamp default current_timestamp not null,
    Person_ID_Edit        int                                 null,
    constraint UnqKFrntnUsrFrntnUsrUsrnm
        unique (FrontendUser_Username),
    constraint FrgKFrntnUsrPrsnID
        foreign key (Person_ID) references Person (Person_ID)
            on delete cascade,
    constraint FrgKFrntnUsrPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKFrntnUsrPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ImportType
(
    ImportType_Code   varchar(255)                         not null
        primary key,
    ImportType_Active tinyint(1) default 1                 not null,
    Timestamp_Create  timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create  int                                  null,
    Timestamp_Edit    timestamp  default current_timestamp not null,
    Person_ID_Edit    int                                  null,
    ImportType_Order  int        default 0                 not null,
    constraint FrgKImprtTpPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKImprtTpPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Import
(
    Import_ID        int auto_increment
        primary key,
    Article_ID       int                                  not null,
    ImportType_Code  varchar(255)                         not null,
    Import_Name      varchar(255)                         not null,
    Import_Data      mediumtext                           null,
    Import_Active    tinyint(1) default 0                 not null,
    Import_Day       int                                  null,
    Import_Hour      int                                  null,
    Import_Minute    int                                  null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    constraint FrgKImprtArtclID
        foreign key (Article_ID) references Article (Article_ID),
    constraint FrgKImprtImprtTpCd
        foreign key (ImportType_Code) references ImportType (ImportType_Code),
    constraint FrgKImprtPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKImprtPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Locale
(
    Locale_Code      varchar(255)                         not null
        primary key,
    Locale_UrlCode   varchar(255)                         not null,
    Locale_Domain    varchar(255)                         null,
    Locale_Name      varchar(255)                         not null,
    Locale_Active    tinyint(1) default 0                 not null,
    Locale_Order     int        default 0                 not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    constraint UnqKLclLclUrlCd
        unique (Locale_UrlCode),
    constraint FrgKLclPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKLclPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists ArticleTranslation
(
    Article_ID                    int                                  not null,
    Locale_Code                   varchar(255)                         not null,
    ArticleTranslation_Code       varchar(255)                         not null,
    ArticleTranslation_Host       varchar(255)                         null,
    ArticleTranslation_Active     tinyint(1) default 1                 not null,
    ArticleTranslation_Name       varchar(255)                         not null,
    ArticleTranslation_Title      varchar(255)                         null,
    ArticleTranslation_Keywords   varchar(255)                         null,
    ArticleTranslation_Heading    varchar(255)                         null,
    ArticleTranslation_SubHeading varchar(255)                         null,
    ArticleTranslation_Path       varchar(255)                         null,
    ArticleTranslation_Teaser     mediumtext                           null,
    ArticleTranslation_Text       mediumtext                           null,
    ArticleTranslation_Footer     mediumtext                           null,
    File_ID                       int                                  null,
    Timestamp_Create              timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create              int                                  null,
    Timestamp_Edit                timestamp  default current_timestamp not null,
    Person_ID_Edit                int                                  null,
    primary key (Article_ID, Locale_Code),
    constraint UnqKArtclTrnslLclCdArtclTrnslCd
        unique (Locale_Code, ArticleTranslation_Code),
    constraint FrgKArtclTrnslArtclID
        foreign key (Article_ID) references Article (Article_ID)
            on delete cascade,
    constraint FrgKArtclTrnslFlID
        foreign key (File_ID) references File (File_ID),
    constraint FrgKArtclTrnslLclCd
        foreign key (Locale_Code) references Locale (Locale_Code),
    constraint FrgKArtclTrnslPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclTrnslPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create or replace index IndArtclTrnslArtclTrnslHst
    on ArticleTranslation (ArticleTranslation_Host);

create or replace index IndLclLclActv
    on Locale (Locale_Active);

create or replace index IndLclLclDmn
    on Locale (Locale_Domain);

create or replace index IndLclLclUrlCd
    on Locale (Locale_UrlCode);

create table if not exists Picture
(
    Picture_ID       int auto_increment
        primary key,
    File_ID          int                                 not null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint FrgKPctrFlID
        foreign key (File_ID) references File (File_ID),
    constraint FrgKPctrPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKPctrPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Article_Picture
(
    Article_ID            int                                 not null,
    Picture_ID            int                                 not null,
    Timestamp_Create      timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                 null,
    Timestamp_Edit        timestamp default current_timestamp not null,
    Person_ID_Edit        int                                 null,
    Article_Picture_Order int       default 0                 not null,
    primary key (Article_ID, Picture_ID),
    constraint FrgKArtclPctrArtclID
        foreign key (Article_ID) references Article (Article_ID),
    constraint FrgKArtclPctrPctrID
        foreign key (Picture_ID) references Picture (Picture_ID)
            on delete cascade,
    constraint FrgKArtclPctrPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKArtclPctrPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists TaskLog
(
    TaskLog_ID       int auto_increment
        primary key,
    TaskLog_Message  varchar(255)                        null,
    TaskLog_Text     mediumtext                          null,
    TaskLog_Data     mediumtext                          null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint FrgKTskLgPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKTskLgPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists Translation
(
    Translation_ID        int auto_increment
        primary key,
    Translation_Code      varchar(255)                        not null,
    Locale_Code           varchar(255)                        not null,
    Translation_Namespace varchar(255)                        not null,
    Translation_Text      mediumtext                          null,
    Timestamp_Create      timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                 null,
    Timestamp_Edit        timestamp default current_timestamp not null,
    Person_ID_Edit        int                                 null,
    constraint UnqKTrnslTrnslCdLclCdTrnslNmspc
        unique (Translation_Code, Locale_Code, Translation_Namespace),
    constraint FrgKTrnslLclCd
        foreign key (Locale_Code) references Locale (Locale_Code),
    constraint FrgKTrnslPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKTrnslPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists UserPermission
(
    UserPermission_Code   varchar(255)                         not null
        primary key,
    UserPermission_Active tinyint(1) default 1                 not null,
    Timestamp_Create      timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create      int                                  null,
    Timestamp_Edit        timestamp  default current_timestamp not null,
    Person_ID_Edit        int                                  null,
    UserPermission_Order  int        default 0                 not null,
    constraint FrgKUsrPrmssPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrPrmssPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists UserRole
(
    UserRole_ID      int auto_increment
        primary key,
    UserRole_Code    varchar(255)                         not null,
    UserRole_Name    varchar(255)                         not null,
    UserRole_Active  tinyint(1) default 1                 not null,
    Timestamp_Create timestamp  default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                  null,
    Timestamp_Edit   timestamp  default current_timestamp not null,
    Person_ID_Edit   int                                  null,
    UserRole_Order   int        default 0                 not null,
    constraint UnqKUsrRlUsrRlCd
        unique (UserRole_Code),
    constraint FrgKUsrRlPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrRlPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create or replace index IndUsrRlUsrRlCd
    on UserRole (UserRole_Code);

create table if not exists UserRole_UserPermission
(
    UserRole_ID         int                                 not null,
    UserPermission_Code varchar(255)                        not null,
    Timestamp_Create    timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create    int                                 null,
    Timestamp_Edit      timestamp default current_timestamp not null,
    Person_ID_Edit      int                                 null,
    primary key (UserRole_ID, UserPermission_Code),
    constraint FrgKUsrRlUsrPrmssPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrRlUsrPrmssPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID),
    constraint FrgKUsrRlUsrPrmssUsrPrmssCd
        foreign key (UserPermission_Code) references UserPermission (UserPermission_Code)
            on delete cascade,
    constraint FrgKUsrRlUsrPrmssUsrRlID
        foreign key (UserRole_ID) references UserRole (UserRole_ID)
            on delete cascade
);

create table if not exists UserState
(
    UserState_Code   varchar(255)                        not null
        primary key,
    UserState_Active tinyint(1)                          not null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint FrgKUsrSttPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrSttPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID)
);

create table if not exists User
(
    Person_ID        int                                 not null
        primary key,
    UserState_Code   varchar(255)                        not null,
    User_Username    varchar(255)                        not null,
    User_Displayname varchar(255)                        not null,
    User_Password    varchar(255)                        not null,
    User_LastLogin   timestamp default current_timestamp not null on update current_timestamp,
    Locale_Code      varchar(255)                        not null,
    Timestamp_Create timestamp default current_timestamp not null,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    constraint UnqKUsrUsrUsrnm
        unique (User_Username),
    constraint FrgKUsrLclCd
        foreign key (Locale_Code) references Locale (Locale_Code),
    constraint FrgKUsrPrsnID
        foreign key (Person_ID) references Person (Person_ID)
            on delete cascade,
    constraint FrgKUsrPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID),
    constraint FrgKUsrUsrSttCd
        foreign key (UserState_Code) references UserState (UserState_Code)
);

create table if not exists User_UserRole
(
    Person_ID        int                                 not null,
    UserRole_ID      int                                 not null,
    Timestamp_Create timestamp default current_timestamp not null on update current_timestamp,
    Person_ID_Create int                                 null,
    Timestamp_Edit   timestamp default current_timestamp not null,
    Person_ID_Edit   int                                 null,
    primary key (Person_ID, UserRole_ID),
    constraint FrgKUsrUsrRlPrsnID
        foreign key (Person_ID) references User (Person_ID)
            on delete cascade,
    constraint FrgKUsrUsrRlPrsnIDCrt
        foreign key (Person_ID_Create) references Person (Person_ID),
    constraint FrgKUsrUsrRlPrsnIDEdt
        foreign key (Person_ID_Edit) references Person (Person_ID),
    constraint FrgKUsrUsrRlUsrRlID
        foreign key (UserRole_ID) references UserRole (UserRole_ID)
            on delete cascade
);

