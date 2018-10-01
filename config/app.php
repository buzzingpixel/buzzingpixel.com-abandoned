<?php
declare(strict_types=1);

use src\app\AppModule;

return [
    'modules' => [
        'app-module' => AppModule::class,
    ],
    'bootstrap' => [
        'app-module',
    ],
];
