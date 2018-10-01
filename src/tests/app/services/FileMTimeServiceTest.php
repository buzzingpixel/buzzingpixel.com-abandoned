<?php
declare(strict_types=1);

namespace src\tests\app\services;

use PHPUnit\Framework\TestCase;
use src\app\services\FileMTimeService;

/**
 * Class FileTimeTwigExtensionTest
 */
class FileMTimeServiceTest extends TestCase
{
    /**
     * Tests getFileTime() method
     */
    public function testGetFileTime()
    {
        $dir = \dirname(__DIR__, 2) . '/_testingSupport/FileTimeSupport/';

        $testFileTime = filemtime("{$dir}TestFile.txt");

        $class = new FileMTimeService(
            \dirname(__DIR__, 2) . '/_testingSupport/FileTimeSupport/'
        );

        self::assertEquals($testFileTime, $class->getFileTime('TestFile.txt'));

        self::assertEquals(
            $testFileTime,
            $class->getFileTime("{$dir}TestFile.txt")
        );

        $noFileTest = $class->getFileTime("{$dir}TestFile.txt-asdf");

        self::assertNotEmpty($noFileTest);

        self::assertNotEquals(
            $testFileTime,
            $noFileTest
        );

        self::assertEquals(
            '0',
            $class->getFileTime("{$dir}TestFile.txt-asdf", false)
        );
    }
}
