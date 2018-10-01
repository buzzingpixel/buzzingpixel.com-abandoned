<?php
declare(strict_types=1);

namespace src\app\actioncontrollers;

use src\app\Di;
use yii\web\Response;
use src\app\exceptions\DiBuilderException;
use src\app\controllers\IndexPageController as IndexPageControllerReal;

/**
 * Class IndexPageController
 * @untested
 */
class IndexPageController extends AbstractBaseController
{
    /**
     * Renders the page
     * @return Response
     * @throws DiBuilderException
     */
    public function actionRender(): Response
    {
        /** @var IndexPageControllerReal $indexPageController */
        $indexPageController = Di::get(IndexPageControllerReal::class);
        return $indexPageController->render();
    }
}
