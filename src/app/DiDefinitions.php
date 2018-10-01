<?php
declare(strict_types=1);

use src\app\Di;
use Michelf\SmartyPants;
use src\app\services\CacheService;
use src\app\factories\MinifyFactory;
use src\app\services\TypesetService;
use src\app\services\FileMTimeService;
use src\app\factories\TruncationFactory;
use buzzingpixel\craftstatic\Craftstatic;
use src\app\services\EntryRoutingService;
use src\app\services\RenderTemplateService;
use src\app\controllers\IndexPageController;
use src\app\twigextensions\TypesetTwigExtension;
use src\app\twigextensions\FileTimeTwigExtension;
use src\app\services\RenderTemplateInternalService;

return [

    /**
     * Controllers
     */
    IndexPageController::class => function () {
        return new IndexPageController(
            Di::get(RenderTemplateService::class)
        );
    },

    /**
     * Factories
     */
    MinifyFactory::class => function () {
        return new MinifyFactory();
    },
    TruncationFactory::class => function () {
        return new TruncationFactory();
    },

    /**
     * Services
     */
    CacheService::class => function () {
        return new CacheService();
    },
    EntryRoutingService::class => function () {
        return new EntryRoutingService();
    },
    FileMTimeService::class => function () {
        return new FileMTimeService(CRAFT_BASE_PATH);
    },
    RenderTemplateInternalService::class => function () {
        return new RenderTemplateInternalService();
    },
    RenderTemplateService::class => function () {
        return new RenderTemplateService(
            Di::get(RenderTemplateInternalService::class),
            new MinifyFactory(),
            Craftstatic::$plugin->getStaticHandler()
        );
    },
    TypesetService::class => function () {
        return new TypesetService(new SmartyPants());
    },

    /**
     * Twig extensions
     */
    FileTimeTwigExtension::class => function () {
        return new FileTimeTwigExtension(Di::get(FileMTimeService::class));
    },
    TypesetTwigExtension::class => function () {
        return new TypesetTwigExtension(
            Di::get(TypesetService::class),
            Di::get(TruncationFactory::class)
        );
    },

];
