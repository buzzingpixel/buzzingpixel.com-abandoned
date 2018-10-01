<?php
declare(strict_types=1);

return [
    '*' => [
        'allowUpdates' => false,
        'appId' => 'BuzzingPixel',
        'cacheDuration' => 0,
        'cacheMethod' => 'apc',
        'basePath' => CRAFT_BASE_PATH,
        'cpTrigger' => 'cms',
        'devMode' => getenv('DEV_MODE') === 'true',
        'errorTemplatePrefix' => '_errors/',
        'generateTransformsBeforePageLoad' => true,
        'isSystemOn' => true,
        'maxUploadFileSize' => 512000000,
        'omitScriptNameInUrls' => true,
        'postCpLoginRedirect' => 'entries',
        'projectPath' => CRAFT_BASE_PATH,
        'rememberedUserSessionDuration' => 'P100Y', // 100 years
        'runQueueAutomatically' => getenv('DISABLE_AUTOMATIC_QUEUE') !== 'true',
        'securityKey' => getenv('SECURITY_KEY'),
        'sendPoweredByHeader' => false,
        'siteName' => 'BuzzingPixel',
        'siteUrl' => getenv('SITE_URL'),
        'suppressTemplateErrors' => getenv('DEV_MODE') !== 'true',
        'timezone' => 'America/Chicago',
        'useEmailAsUsername' => true,
        'userSessionDuration' => false, // As long as browser stays open
        'staticAssetCacheTime' => '',
    ],
];
