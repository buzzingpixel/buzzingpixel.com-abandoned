<?php
declare(strict_types=1);

return [

    /**************************************************************************/
    /* Pages routing */
    /**************************************************************************/

    // Index page
    /** @see \src\app\actioncontrollers\IndexPageController::actionRender() */
    /** @see \src\app\controllers\IndexPageController::render() */
    'GET /' => 'app-module/index-page/render',

];
