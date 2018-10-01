<?php
declare(strict_types=1);

namespace src\app\services;

use craft\elements\Entry;
use craft\events\SetElementRouteEvent;
use craft\models\Section_SiteSettings;

/**
 * Class EntryService
 */
class EntryRoutingService
{
    /**
     * Handles entry controller routing. To route an entry to a controller, in
     * the template area of the route when setting up the channel, prefix the
     * route with `_controllerRoute/`, followed by a standard routing key as you
     * would use in the route config file
     * @param SetElementRouteEvent $eventModel
     */
    public function routeEntryToController(SetElementRouteEvent $eventModel)
    {
        /** @var Entry $entry */
        $entry = $eventModel->sender;

        try {
            $section = $entry->getSection();
        } catch (\Exception $e) {
            return;
        }

        /** @var Section_SiteSettings $sectionSiteSettingsModel */
        $sectionSiteSettingsModel = $section->getSiteSettings()[1];

        $routeArray = explode('/', $sectionSiteSettingsModel->template);

        if (! isset($routeArray[0]) || $routeArray[0] !== '_controllerRoute') {
            return;
        }

        unset($routeArray[0]);

        $route = implode('/', $routeArray);

        $eventModel->route = [$route, [
            'entry' => $entry
        ]];
    }
}
