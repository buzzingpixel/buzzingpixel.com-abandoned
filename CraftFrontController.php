<?php
declare(strict_types=1);

/**
 * CraftCMS front controller
 */

$sep = DIRECTORY_SEPARATOR;
define('CRAFT_BASE_PATH', __DIR__);
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH . $sep . 'vendor');

require_once CRAFT_VENDOR_PATH . $sep . 'autoload.php';

if (file_exists(CRAFT_BASE_PATH . $sep . '.env')) {
    (new Dotenv\Dotenv(CRAFT_BASE_PATH))->load();
}

$craftStoragePath = CRAFT_BASE_PATH . $sep . 'storage';

if (getenv('DOCKER_STORAGE_SYMLINK') === 'true') {
    $appPath = $sep . 'app';
    $tmpAppStorage = $sep . 'tmp' . $sep . 'appStorage';
    $tmpStoragePath = $tmpAppStorage . $sep . 'storage';

    if (! is_link($tmpStoragePath) ||
        ! is_dir($tmpStoragePath) ||
        realpath($craftStoragePath) !== $tmpStoragePath
    ) {
        exec('mkdir -p ' . $tmpStoragePath);
        exec('chmod -R 0777 ' . $tmpAppStorage);
        exec('ln -sf ' . $tmpStoragePath . ' ' . $appPath);
    }
} elseif (! file_exists($craftStoragePath) &&
    ! is_dir($craftStoragePath)
) {
    exec('sudo mkdir -p ' . $craftStoragePath);
    exec('sudo chmod -R 0777 ' . $craftStoragePath);
}

if (! file_exists(CRAFT_BASE_PATH . $sep . 'config' . $sep . 'license.key')) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw new \Exception(
        'Please place the license.key file at `config/license.key`'
    );
}

define('CRAFT_ENVIRONMENT', getenv('ENVIRONMENT') ?: 'dev');

if (PHP_SAPI === 'cli') {
    $app = require CRAFT_VENDOR_PATH . $sep . 'craftcms' . $sep . 'cms' . $sep .
        'bootstrap' . $sep . 'console.php';

    $exitCode = $app->run();

    exit($exitCode);
}

$app = require CRAFT_VENDOR_PATH . $sep . 'craftcms' . $sep . 'cms' . $sep .
    'bootstrap' . $sep . 'web.php';

$app->run();
