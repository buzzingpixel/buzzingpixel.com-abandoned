<?php
declare(strict_types=1);

namespace src\app;

use Craft;
use yii\base\Event;
use yii\base\Module;
use craft\elements\Entry;
use src\app\services\CacheService;
use craft\events\SetElementRouteEvent;
use src\app\services\EntryRoutingService;
use src\app\exceptions\DiBuilderException;
use src\app\twigextensions\TypesetTwigExtension;
use src\app\twigextensions\FileTimeTwigExtension;

/**
 * Class AppModule
 */
class AppModule extends Module
{
    /**
     * Initializes the AppModule (auto run by Yii on module instantiation)
     * @throws DiBuilderException
     */
    public function init()
    {
        $this->setUp();

        $this->setEvents();

        $this->registerTwigExtensions();

        parent::init();

        $this->controllerNamespace = 'src\app\actioncontrollers';
    }

    /**
     * Sets up the module
     * @throws DiBuilderException
     */
    private function setUp()
    {
        Craft::setAlias('@appRoot', CRAFT_BASE_PATH);

        Craft::setAlias('@appModule', __DIR__);

        Craft::setAlias('@src', \dirname(__DIR__));

        if (getenv('CLEAR_TEMPLATE_CACHE_ON_LOAD') === 'true') {
            /** @var CacheService $cacheService */
            $cacheService = Di::get(CacheService::class);
            $cacheService->clearTemplateCache();
        }
    }

    /**
     * Registers twig extensions
     * @throws DiBuilderException
     */
    private function registerTwigExtensions()
    {
        $view = Craft::$app->view;

        $view->registerTwigExtension(Di::get(FileTimeTwigExtension::class));

        $view->registerTwigExtension(Di::get(TypesetTwigExtension::class));
    }

    /**
     * Sets events
     */
    private function setEvents()
    {
        Event::on(
            Entry::class,
            Entry::EVENT_SET_ROUTE,
            function (SetElementRouteEvent $event) {
                /** @var EntryRoutingService $entryRoutingService */
                $entryRoutingService = Di::get(EntryRoutingService::class);
                $entryRoutingService->routeEntryToController($event);
            }
        );
    }
}
