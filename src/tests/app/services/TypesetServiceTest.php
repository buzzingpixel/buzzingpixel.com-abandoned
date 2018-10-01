<?php
declare(strict_types=1);

namespace src\tests\app\services;

use Michelf\SmartyPants;
use PHPUnit\Framework\TestCase;
use src\app\services\TypesetService;

/**
 * Class TypesetServiceTest
 */
class TypesetServiceTest extends TestCase
{
    /**
     * Tests typeset method
     */
    public function testTypeset()
    {
        $smartyPants = $this->createMock(SmartyPants::class);

        $smartyPants->expects(self::once())
            ->method('transform')
            ->with(self::equalTo('inputString'))
            ->willReturn('<p>More testing of things</p><p>Even more.</p>');

        /** @var SmartyPants $smartyPants */

        $class = new TypesetService($smartyPants);

        self::assertEquals(
            '<p>More testing of&nbsp;things</p><p>Even&nbsp;more.</p>',
            $class->typeset('inputString')
        );
    }

    /**
     * Tests widont() method
     */
    public function testWidont()
    {
        $smartyPants = $this->createMock(SmartyPants::class);

        /** @var SmartyPants $smartyPants */

        $class = new TypesetService($smartyPants);

        self::assertEquals(
            'This is a&nbsp;test',
            $class->widont('This is a test')
        );

        self::assertEquals(
            '<p>More testing of&nbsp;things</p><p>Even&nbsp;more.</p>',
            $class->widont('<p>More testing of things</p><p>Even more.</p>')
        );
    }

    /**
     * Tests smartypants() method
     */
    public function testSmartypants()
    {
        $smartyPants = $this->createMock(SmartyPants::class);

        $smartyPants->expects(self::once())
            ->method('transform')
            ->with(self::equalTo('inputString'))
            ->willReturn('testText');

        /** @var SmartyPants $smartyPants */

        $class = new TypesetService($smartyPants);

        self::assertEquals(
            'testText',
            $class->smartypants('inputString')
        );
    }
}
