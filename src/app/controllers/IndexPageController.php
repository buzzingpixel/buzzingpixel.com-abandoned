<?php
declare(strict_types=1);

namespace src\app\controllers;

use yii\web\Response;
use src\app\services\RenderTemplateService;

/**
 * Class IndexPageController
 */
class IndexPageController
{
    /** @var RenderTemplateService $renderTemplateService */
    private $renderTemplateService;

    /**
     * IndexPageController constructor
     * @param RenderTemplateService $renderTemplateService
     */
    public function __construct(RenderTemplateService $renderTemplateService)
    {
        $this->renderTemplateService = $renderTemplateService;
    }

    /**
     * Renders the page
     * @return Response
     */
    public function render(): Response
    {
        return $this->renderTemplateService->renderTemplate(
            '_core/IndexPage.twig'
        );
    }
}
