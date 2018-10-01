<?php
declare(strict_types=1);

namespace src\tests\app\twigextensions;

use Twig_Markup;
use TS\Text\Truncation;
use PHPUnit\Framework\TestCase;
use src\app\services\TypesetService;
use src\app\twigextensions\TypesetTwigExtension;
use src\app\factories\TruncationFactory;

/**
 * Class TypesetTwigExtensionTest
 */
class TypesetTwigExtensionTest extends TestCase
{
    /**
     * Tests getFilters() method
     */
    public function testGetFilters()
    {
        $typesetService = $this->createMock(TypesetService::class);
        $truncationFactory = $this->createMock(TruncationFactory::class);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $filters = $class->getFilters();

        self::assertCount(5, $filters);

        $names = [
            'typeset' => 'typesetFilter',
            'smartypants' => 'smartypantsFilter',
            'widont' => 'widontFilter',
            'truncate' => 'truncateFilter',
            'ucfirst' => 'ucfirstFilter',
        ];

        $setNames = [];

        foreach ($filters as $filter) {
            $name = $filter->getName();

            self::assertArrayHasKey($name, $names);

            $setNames[$name] = $name;

            $callable = $filter->getCallable();

            self::assertCount(2, $callable);

            self::assertInstanceOf(
                TypesetTwigExtension::class,
                $callable[0]
            );

            self::assertEquals(
                $names[$name],
                $callable[1]
            );
        }
    }

    /**
     * Tests typesetFilter() method
     */
    public function testTypesetFilter()
    {
        $typesetService = $this->createMock(TypesetService::class);

        $typesetService->expects(self::once())
            ->method('typeset')
            ->with(self::equalTo('inputString'))
            ->willReturn('typesetOutputString');

        $truncationFactory = $this->createMock(TruncationFactory::class);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $twigMarkup = $class->typesetFilter('inputString');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'typesetOutputString',
            $twigMarkup->__toString()
        );
    }

    /**
     * Tests smartypantsFilter() method
     */
    public function testSmartypantsFilter()
    {
        $typesetService = $this->createMock(TypesetService::class);

        $typesetService->expects(self::once())
            ->method('smartypants')
            ->with(self::equalTo('smartypantsInputString'))
            ->willReturn('smartypantsTypesetOutputString');

        $truncationFactory = $this->createMock(TruncationFactory::class);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $twigMarkup = $class->smartypantsFilter('smartypantsInputString');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'smartypantsTypesetOutputString',
            $twigMarkup->__toString()
        );
    }

    /**
     * Tests widontFilter() method
     */
    public function testWidontFilter()
    {
        $typesetService = $this->createMock(TypesetService::class);

        $typesetService->expects(self::once())
            ->method('widont')
            ->with(self::equalTo('widontInputString'))
            ->willReturn('widontTypesetOutputString');

        $truncationFactory = $this->createMock(TruncationFactory::class);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $twigMarkup = $class->widontFilter('widontInputString');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'widontTypesetOutputString',
            $twigMarkup->__toString()
        );
    }

    /**
     * Tests truncateFilter() method
     * @throws \Exception
     */
    public function testTruncateFilter()
    {
        $val = 'testVal';
        $limit = 3;
        $strategy = 'paragraph';
        $truncationString = 'truncString';
        $minLength = 8;

        $truncationMock = $this->createMock(Truncation::class);

        $truncationMock->expects(self::once())
            ->method('truncate')
            ->with(self::equalTo($val))
            ->willReturn('truncationOutputVal');

        $typesetService = $this->createMock(TypesetService::class);

        $truncationFactory = $this->createMock(TruncationFactory::class);

        $truncationFactory->expects(self::once())
            ->method('make')
            ->with(
                self::equalTo($limit),
                self::equalTo($strategy),
                self::equalTo($truncationString),
                self::equalTo($minLength)
            )
            ->willReturn($truncationMock);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $twigMarkup = $class->truncateFilter(
            $val,
            $limit,
            $strategy,
            $truncationString,
            $minLength
        );

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'truncationOutputVal',
            $twigMarkup->__toString()
        );
    }

    /**
     * Tests ucfirstFilter() method
     */
    public function testUcfirstFilter()
    {
        $typesetService = $this->createMock(TypesetService::class);

        $truncationFactory = $this->createMock(TruncationFactory::class);

        /** @var TypesetService $typesetService */
        /** @var TruncationFactory $truncationFactory */

        $class = new TypesetTwigExtension(
            $typesetService,
            $truncationFactory
        );

        $twigMarkup = $class->ucfirstFilter('testVal');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'TestVal',
            $twigMarkup->__toString()
        );

        $twigMarkup = $class->ucfirstFilter('test val');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'Test val',
            $twigMarkup->__toString()
        );

        $twigMarkup = $class->ucfirstFilter('tEST');

        self::assertInstanceOf(
            Twig_Markup::class,
            $twigMarkup
        );

        self::assertEquals(
            'TEST',
            $twigMarkup->__toString()
        );
    }
}
