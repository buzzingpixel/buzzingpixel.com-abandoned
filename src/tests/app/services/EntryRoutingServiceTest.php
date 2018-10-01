<?php
declare(strict_types=1);

namespace src\tests\app\services;

use craft\elements\Entry;
use craft\models\Section;
use PHPUnit\Framework\TestCase;
use craft\events\SetElementRouteEvent;
use craft\models\Section_SiteSettings;
use src\app\services\EntryRoutingService;

/**
 * Class EntryRoutingServiceTest
 */
class EntryRoutingServiceTest extends TestCase
{
    /**
     * Tests entryControllerRouting() method
     */
    public function testEntryControllerRouting()
    {
        $entry = $this->createMock(Entry::class);

        $entry->expects(self::once())
            ->method('getSection')
            ->willThrowException(new \Exception('Test Exception'));

        $eventModel = $this->createMock(SetElementRouteEvent::class);

        /** @var SetElementRouteEvent $eventModel */

        $eventModel->sender = $entry;

        $class = new EntryRoutingService();

        self::assertNull($class->routeEntryToController($eventModel));

        self::assertNull($eventModel->route);

        /**********************************************************************/

        $sectionSiteSettingsModel = $this->createMock(
            Section_SiteSettings::class
        );

        /** @var Section_SiteSettings $sectionSiteSettingsModel */

        $sectionSiteSettingsModel->template = 'asdf';

        $section = $this->createMock(Section::class);

        $section->expects(self::once())
            ->method('getSiteSettings')
            ->willReturn([1 => $sectionSiteSettingsModel]);

        $entry = $this->createMock(Entry::class);

        $entry->expects(self::once())
            ->method('getSection')
            ->willReturn($section);

        $eventModel = $this->createMock(SetElementRouteEvent::class);

        /** @var SetElementRouteEvent $eventModel */

        $eventModel->sender = $entry;

        $class = new EntryRoutingService();

        self::assertNull($class->routeEntryToController($eventModel));

        self::assertNull($eventModel->route);

        /**********************************************************************/

        $sectionSiteSettingsModel = $this->createMock(
            Section_SiteSettings::class
        );

        /** @var Section_SiteSettings $sectionSiteSettingsModel */

        $sectionSiteSettingsModel->template = '_controllerRoute/asdf/route/thing';

        $section = $this->createMock(Section::class);

        $section->expects(self::once())
            ->method('getSiteSettings')
            ->willReturn([1 => $sectionSiteSettingsModel]);

        $entry = $this->createMock(Entry::class);

        $entry->expects(self::once())
            ->method('getSection')
            ->willReturn($section);

        /** @var Entry $entry */

        $entry->id = 123;

        $eventModel = $this->createMock(SetElementRouteEvent::class);

        /** @var SetElementRouteEvent $eventModel */

        $eventModel->sender = $entry;

        $class = new EntryRoutingService();

        self::assertNull($class->routeEntryToController($eventModel));

        self::assertEquals('asdf/route/thing', $eventModel->route[0]);

        self::assertEquals($entry, $eventModel->route[1]['entry']);

        self::assertEquals(123, $eventModel->route[1]['entry']->id);
    }
}
