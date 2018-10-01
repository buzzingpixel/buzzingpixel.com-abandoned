<?php
declare(strict_types=1);

namespace src\app\services;

use Craft;
use yii\web\Response;
use craft\helpers\FileHelper;

/**
 * Class RenderTemplateService
 * @untested
 */
class RenderTemplateInternalService
{
    /**
     * Taken from @see \craft\web\Controller::renderTemplate()
     * @param string $template The name of the template to load
     * @param array $variables Variables to make available to template
     * @return Response
     */
    public function renderTemplate(
        string $template,
        array $variables = []
    ): Response {
        $response = Craft::$app->getResponse();
        $headers = $response->getHeaders();

        // Set the MIME type for the request based on the matched template's
        // file extension (unless the Content-Type header was already set,
        // perhaps by the template via the {% header %} tag)
        if (! $headers->has('content-type')) {
            $templateFile = Craft::$app->getView()->resolveTemplate($template);
            $extension = pathinfo($templateFile, PATHINFO_EXTENSION) ?: 'html';

            $mimeType = FileHelper::getMimeTypeByExtension('.' . $extension);

            if ($mimeType === null) {
                $mimeType = 'text/html';
            }

            $headers->set(
                'content-type',
                $mimeType . '; charset=' . $response->charset
            );
        }

        // Render and return the template
        $response->data = Craft::$app->getView()->renderPageTemplate(
            $template,
            $variables
        );

        // Prevent a response formatter from overriding the content-type header
        $response->format = Response::FORMAT_RAW;

        return $response;
    }
}
