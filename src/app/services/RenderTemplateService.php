<?php
declare(strict_types=1);

namespace src\app\services;

use yii\web\Response;
use src\app\factories\MinifyFactory;
use buzzingpixel\craftstatic\services\StaticHandlerService;

/**
 * Class RenderTemplateService
 */
class RenderTemplateService
{
    /** @var RenderTemplateInternalService $renderTemplateInternalService */
    private $renderTemplateInternalService;

    /** @var MinifyFactory $minifyFactory */
    private $minifyFactory;

    /** @var StaticHandlerService $staticHandlerService */
    private $staticHandlerService;

    /**
     * RenderTemplateService constructor
     * @param RenderTemplateInternalService $renderTemplateInternalService
     * @param MinifyFactory $minifyFactory
     * @param StaticHandlerService $staticHandlerService
     */
    public function __construct(
        RenderTemplateInternalService $renderTemplateInternalService,
        MinifyFactory $minifyFactory,
        StaticHandlerService $staticHandlerService
    ) {
        $this->renderTemplateInternalService = $renderTemplateInternalService;
        $this->minifyFactory = $minifyFactory;
        $this->staticHandlerService = $staticHandlerService;
    }

    /**
     * Renders a template, minifies HTML if requested, and returns a response
     * @param string $template The name of the template to load
     * @param array $variables Variables to make available to template
     * @param bool $cache Should static caching be used?
     * @param bool $minify Should minification be used
     * @return Response
     */
    public function renderTemplate(
        string $template,
        array $variables = [],
        bool $cache = true,
        bool $minify = true
    ): Response {
        $response = $this->renderTemplateInternalService->renderTemplate(
            $template,
            $variables
        );

        if ($minify) {
            $response->data = $this->minifyFactory->make($response->data)
                ->process();
        }

        if ($cache && getenv('STATIC_CACHE_ENABLED') === 'true') {
            $this->staticHandlerService->handleContent($response->data);
        }

        return $response;
    }
}
