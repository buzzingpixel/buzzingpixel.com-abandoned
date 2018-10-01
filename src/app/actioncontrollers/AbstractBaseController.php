<?php
declare(strict_types=1);

namespace src\app\actioncontrollers;

use craft\web\Controller;

/**
 * Class AbstractBaseController
 */
abstract class AbstractBaseController extends Controller
{
    /**
     * Allows the controller to be accessed by any web request
     * @var bool $allowAnonymous
     */
    protected $allowAnonymous = true;
}
