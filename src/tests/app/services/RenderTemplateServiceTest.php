<?php
declare(strict_types=1);

namespace src\tests\app\services;

use Minify_HTML;
use yii\web\Response;
use PHPUnit\Framework\TestCase;
use src\app\services\RenderTemplateService;
use src\app\factories\MinifyFactory;
use buzzingpixel\craftstatic\services\StaticHandlerService;
use src\app\services\RenderTemplateInternalService as InternalRenderTemplateService;

/**
 * Class RenderTemplateServiceTest
 */
class RenderTemplateServiceTest extends TestCase
{
    public function testRenderTemplate()
    {
        /** @var Response $response */
        $response = $this->createMock(Response::class);
        $response->data = 'responseDataTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar' => 'testVal'])
            )
            ->willReturn($response);

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(0))
            ->method('handleContent');

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=false');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar' => 'testVal'],
            false,
            false
        );

        self::assertEquals($response, $classReturn);

        self::assertEquals('responseDataTest', $classReturn->data);

        /**********************************************************************/

        /** @var Response $renderTemplateResponse */
        $renderTemplateResponse = $this->createMock(Response::class);
        $renderTemplateResponse->data = 'renderTemplateResponseTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar2' => 'testVal2'])
            )
            ->willReturn($renderTemplateResponse);

        $minify = $this->createMock(Minify_HTML::class);

        $minify->expects(self::once())
            ->method('process')
            ->with()
            ->willReturn('minifyProcessResponseTest');

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $minifyFactory->expects(self::once())
            ->method('make')
            ->with(self::equalTo('renderTemplateResponseTest'))
            ->willReturn($minify);

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(0))
            ->method('handleContent');

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=false');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar2' => 'testVal2'],
            false,
            true
        );

        self::assertEquals($renderTemplateResponse, $classReturn);

        self::assertEquals('minifyProcessResponseTest', $classReturn->data);

        /**********************************************************************/

        /** @var Response $renderTemplateResponse */
        $renderTemplateResponse = $this->createMock(Response::class);
        $renderTemplateResponse->data = 'renderTemplateResponseTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar2' => 'testVal2'])
            )
            ->willReturn($renderTemplateResponse);

        $minify = $this->createMock(Minify_HTML::class);

        $minify->expects(self::once())
            ->method('process')
            ->with()
            ->willReturn('minifyProcessResponseTest');

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $minifyFactory->expects(self::once())
            ->method('make')
            ->with(self::equalTo('renderTemplateResponseTest'))
            ->willReturn($minify);

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(0))
            ->method('handleContent');

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=false');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar2' => 'testVal2'],
            true,
            true
        );

        self::assertEquals($renderTemplateResponse, $classReturn);

        self::assertEquals('minifyProcessResponseTest', $classReturn->data);

        /**********************************************************************/

        /** @var Response $renderTemplateResponse */
        $renderTemplateResponse = $this->createMock(Response::class);
        $renderTemplateResponse->data = 'renderTemplateResponseTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar2' => 'testVal2'])
            )
            ->willReturn($renderTemplateResponse);

        $minify = $this->createMock(Minify_HTML::class);

        $minify->expects(self::once())
            ->method('process')
            ->with()
            ->willReturn('minifyProcessResponseTest');

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $minifyFactory->expects(self::once())
            ->method('make')
            ->with(self::equalTo('renderTemplateResponseTest'))
            ->willReturn($minify);

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(1))
            ->method('handleContent')
            ->with(self::equalTo('minifyProcessResponseTest'));

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=true');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar2' => 'testVal2'],
            true,
            true
        );

        self::assertEquals($renderTemplateResponse, $classReturn);

        self::assertEquals('minifyProcessResponseTest', $classReturn->data);

        /**********************************************************************/

        /** @var Response $renderTemplateResponse */
        $renderTemplateResponse = $this->createMock(Response::class);
        $renderTemplateResponse->data = 'renderTemplateResponseTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar2' => 'testVal2'])
            )
            ->willReturn($renderTemplateResponse);

        $minify = $this->createMock(Minify_HTML::class);

        $minify->expects(self::once())
            ->method('process')
            ->with()
            ->willReturn('minifyProcessResponseTest');

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $minifyFactory->expects(self::once())
            ->method('make')
            ->with(self::equalTo('renderTemplateResponseTest'))
            ->willReturn($minify);

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(0))
            ->method('handleContent');

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=true');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar2' => 'testVal2'],
            false,
            true
        );

        self::assertEquals($renderTemplateResponse, $classReturn);

        self::assertEquals('minifyProcessResponseTest', $classReturn->data);

        /**********************************************************************/

        /** @var Response $renderTemplateResponse */
        $renderTemplateResponse = $this->createMock(Response::class);
        $renderTemplateResponse->data = 'renderTemplateResponseTest';

        $internalRenderTemplateService = $this->createMock(
            InternalRenderTemplateService::class
        );

        $internalRenderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(
                self::equalTo('testTemplateInput'),
                self::equalTo(['testVar2' => 'testVal2'])
            )
            ->willReturn($renderTemplateResponse);

        $minify = $this->createMock(Minify_HTML::class);

        $minify->expects(self::exactly(0))
            ->method('process');

        $minifyFactory = $this->createMock(MinifyFactory::class);

        $minifyFactory->expects(self::exactly(0))
            ->method('make');

        $staticHandlerService = $this->createMock(StaticHandlerService::class);

        $staticHandlerService->expects(self::exactly(1))
            ->method('handleContent')
            ->with(self::equalTo('renderTemplateResponseTest'));

        /** @var InternalRenderTemplateService $internalRenderTemplateService */
        /** @var MinifyFactory $minifyFactory */
        /** @var StaticHandlerService $staticHandlerService */

        putenv('STATIC_CACHE_ENABLED=true');

        $class = new RenderTemplateService(
            $internalRenderTemplateService,
            $minifyFactory,
            $staticHandlerService
        );

        $classReturn = $class->renderTemplate(
            'testTemplateInput',
            ['testVar2' => 'testVal2'],
            true,
            false
        );

        self::assertEquals($renderTemplateResponse, $classReturn);

        self::assertEquals('renderTemplateResponseTest', $classReturn->data);
    }
}
