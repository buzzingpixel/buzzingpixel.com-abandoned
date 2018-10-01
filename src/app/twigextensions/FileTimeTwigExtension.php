<?php
declare(strict_types=1);

namespace src\app\twigextensions;

use Twig_Function;
use Twig_Extension;
use src\app\services\FileMTimeService;

/**
 * Class FileTimeTwigExtension
 */
class FileTimeTwigExtension extends Twig_Extension
{
    /** @var FileMTimeService $fileMTimeService */
    private $fileMTimeService;

    /**
     * FileTimeTwigExtension constructor
     *
     * @param FileMTimeService $fileMTimeService
     */
    public function __construct(FileMTimeService $fileMTimeService)
    {
        $this->fileMTimeService = $fileMTimeService;
    }

    /**
     * Returns the functions for this Twig Extension
     * @return Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('fileTime', [
                $this->fileMTimeService,
                'getFileTime'
            ]),
        ];
    }
}
