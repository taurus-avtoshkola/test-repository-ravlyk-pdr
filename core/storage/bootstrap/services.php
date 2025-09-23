<?php return array (
  'providers' => 
  array (
    'Console_Migration' => 'Illuminate\\Database\\MigrationServiceProvider',
    'Laravel_View' => 'Illuminate\\View\\ViewServiceProvider',
    'Laravel_Database' => 'Illuminate\\Database\\DatabaseServiceProvider',
    'Laravel_Filesystem' => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
    'Laravel_Pagination' => 'Illuminate\\Pagination\\PaginationServiceProvider',
    'Laravel_Cache' => 'Illuminate\\Cache\\CacheServiceProvider',
    'Laravel_Lang' => 'Illuminate\\Translation\\TranslationServiceProvider',
    'Bootstrap_ExceptionHandler' => 'EvolutionCMS\\Providers\\ExceptionHandlerServiceProvider',
    'Console_Artisan' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'Evolution_Observers' => 'EvolutionCMS\\Providers\\ObserversServiceProvider',
    'Evolution_Events' => 'EvolutionCMS\\Providers\\EventServiceProvider',
    'Evolution_DBAPI' => 'EvolutionCMS\\Providers\\DatabaseServiceProvider',
    'Evolution_DEPRECATED' => 'EvolutionCMS\\Providers\\DeprecatedCoreServiceProvider',
    'Evolution_EXPORT_SITE' => 'EvolutionCMS\\Providers\\ExportSiteServiceProvider',
    'Evolution_MODxMailer' => 'EvolutionCMS\\Providers\\MailServiceProvider',
    'Evolution_makeTable' => 'EvolutionCMS\\Providers\\MakeTableServiceProvider',
    'Evolution_ManagerAPI' => 'EvolutionCMS\\Providers\\ManagerApiServiceProvider',
    'Evolution_MODIFIERS' => 'EvolutionCMS\\Providers\\ModifiersServiceProvider',
    'Evolution_phpass' => 'EvolutionCMS\\Providers\\PasswordHashServiceProvider',
    'Evolution_PHPCOMPAT' => 'EvolutionCMS\\Providers\\PhpCompatServiceProvider',
    'Evolution_DocBlock' => 'EvolutionCMS\\Providers\\DocBlockServiceProvider',
    'Evolution_ManagerTheme' => 'EvolutionCMS\\Providers\\ManagerThemeServiceProvider',
    'Evolution_UrlProcessor' => 'EvolutionCMS\\Providers\\UrlProcessorServiceProvider',
    'Evolution_Blade' => 'EvolutionCMS\\Providers\\BladeServiceProvider',
    'Fix_DLTemplate' => 'EvolutionCMS\\Providers\\DLTemplateServiceProvider',
    'Fix_Phx' => 'EvolutionCMS\\Providers\\PhxServiceProvider',
    'Fix_ModResource' => 'EvolutionCMS\\Providers\\ModResourceServiceProvider',
    'Fix_ModUsers' => 'EvolutionCMS\\Providers\\ModUsersServiceProvider',
    'Fix_Fs' => 'EvolutionCMS\\Providers\\FsServiceProvider',
  ),
  'eager' => 
  array (
    0 => 'Illuminate\\View\\ViewServiceProvider',
    1 => 'Illuminate\\Database\\DatabaseServiceProvider',
    2 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
    3 => 'Illuminate\\Pagination\\PaginationServiceProvider',
    4 => 'EvolutionCMS\\Providers\\ExceptionHandlerServiceProvider',
    5 => 'EvolutionCMS\\Providers\\ObserversServiceProvider',
    6 => 'EvolutionCMS\\Providers\\EventServiceProvider',
    7 => 'EvolutionCMS\\Providers\\DatabaseServiceProvider',
    8 => 'EvolutionCMS\\Providers\\DeprecatedCoreServiceProvider',
    9 => 'EvolutionCMS\\Providers\\ExportSiteServiceProvider',
    10 => 'EvolutionCMS\\Providers\\MailServiceProvider',
    11 => 'EvolutionCMS\\Providers\\MakeTableServiceProvider',
    12 => 'EvolutionCMS\\Providers\\ManagerApiServiceProvider',
    13 => 'EvolutionCMS\\Providers\\ModifiersServiceProvider',
    14 => 'EvolutionCMS\\Providers\\PasswordHashServiceProvider',
    15 => 'EvolutionCMS\\Providers\\PhpCompatServiceProvider',
    16 => 'EvolutionCMS\\Providers\\DocBlockServiceProvider',
    17 => 'EvolutionCMS\\Providers\\UrlProcessorServiceProvider',
    18 => 'EvolutionCMS\\Providers\\BladeServiceProvider',
    19 => 'EvolutionCMS\\Providers\\DLTemplateServiceProvider',
    20 => 'EvolutionCMS\\Providers\\PhxServiceProvider',
    21 => 'EvolutionCMS\\Providers\\ModResourceServiceProvider',
    22 => 'EvolutionCMS\\Providers\\ModUsersServiceProvider',
    23 => 'EvolutionCMS\\Providers\\FsServiceProvider',
  ),
  'deferred' => 
  array (
    'migrator' => 'Illuminate\\Database\\MigrationServiceProvider',
    'migration.repository' => 'Illuminate\\Database\\MigrationServiceProvider',
    'migration.creator' => 'Illuminate\\Database\\MigrationServiceProvider',
    'cache' => 'Illuminate\\Cache\\CacheServiceProvider',
    'cache.store' => 'Illuminate\\Cache\\CacheServiceProvider',
    'memcached.connector' => 'Illuminate\\Cache\\CacheServiceProvider',
    'translator' => 'Illuminate\\Translation\\TranslationServiceProvider',
    'translation.loader' => 'Illuminate\\Translation\\TranslationServiceProvider',
    'command.cache.clear' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.cache.forget' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.clear-compiled' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.fresh' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.install' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.refresh' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.reset' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.rollback' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.migrate.status' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.seed' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.view.clear' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'command.vendor.publish' => 'EvolutionCMS\\Providers\\ArtisanServiceProvider',
    'ManagerTheme' => 'EvolutionCMS\\Providers\\ManagerThemeServiceProvider',
  ),
  'when' => 
  array (
    'Illuminate\\Database\\MigrationServiceProvider' => 
    array (
    ),
    'Illuminate\\Cache\\CacheServiceProvider' => 
    array (
    ),
    'Illuminate\\Translation\\TranslationServiceProvider' => 
    array (
    ),
    'EvolutionCMS\\Providers\\ArtisanServiceProvider' => 
    array (
    ),
    'EvolutionCMS\\Providers\\ManagerThemeServiceProvider' => 
    array (
    ),
  ),
);