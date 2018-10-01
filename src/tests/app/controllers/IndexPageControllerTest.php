<?php
declare(strict_types=1);

namespace src\tests\app\controllers;

use yii\web\Response;
use PHPUnit\Framework\TestCase;
use src\app\services\RenderTemplateService;
use src\app\controllers\IndexPageController;

/**
 * Class IndexPageControllerTest
 */
class IndexPageControllerTest extends TestCase
{
    /**
     * Tests the render() method
     */
    public function testRender()
    {
        $response = $this->createMock(Response::class);

        /** @var Response $response */

        $response->data = 'testResponse';

        $renderTemplateService = $this->createMock(RenderTemplateService::class);

        $renderTemplateService->expects(self::once())
            ->method('renderTemplate')
            ->with(self::equalTo('_core/IndexPage.twig'))
            ->willReturn($response);

        /** @var RenderTemplateService $renderTemplateService */

        $class = new IndexPageController($renderTemplateService);

        $classReturn = $class->render();

        self::assertEquals($response, $classReturn);

        self::assertEquals('testResponse', $classReturn->data);
    }
}
