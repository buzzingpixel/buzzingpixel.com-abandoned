<?php
declare(strict_types=1);

namespace src\tests\app\twigextensions;

use PHPUnit\Framework\TestCase;
use src\app\services\FileMTimeService;
use src\app\twigextensions\FileTimeTwigExtension;

/**
 * Class FileTimeTwigExtensionTest
 */
class FileTimeTwigExtensionTest extends TestCase
{
    public function testGetFunctions()
    {
        $fileOperationsService = $this->createMock(FileMTimeService::class);

        /** @var FileMTimeService $fileOperationsService */

        $class = new FileTimeTwigExtension($fileOperationsService);

        $functions = $class->getFunctions();

        self::assertCount(1, $functions);

        $callable = $functions[0]->getCallable();

        self::assertCount(2, $callable);

        self::assertInstanceOf(
            FileMTimeService::class,
            $callable[0]
        );

        self::assertEquals(
            'getFileTime',
            $callable[1]
        );
    }
}
