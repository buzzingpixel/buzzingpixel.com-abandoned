<?php
declare(strict_types=1);

namespace src\app\services;

/**
 * Class FileMTimeService
 */
class FileMTimeService
{
    /** @var string $basePath */
    private $basePath;

    /**
     * FileOperationsService constructor
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Gets a file's modification time, optionally returns uniqid() if filemtime
     * cannot be ascertained
     * @param string $filePath
     * @param bool $uniqidFallback
     * @return string
     */
    public function getFileTime(
        string $filePath = '',
        $uniqidFallback = true
    ): string {
        if (file_exists($filePath)) {
            return (string) filemtime($filePath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = "{$this->basePath}/{$filePath}";

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        if ($uniqidFallback) {
            return uniqid('', false);
        }

        return '0';
    }
}
