<?php
declare(strict_types=1);

namespace src\app;

use Exception;
use DI\Container;
use DI\ContainerBuilder;
use src\app\exceptions\DiBuilderException;

/**
 * Class Di
 */
class Di
{
    /** @var Container $diContainer */
    private static $diContainer;

    /**
     * Gets the DI Container
     * @return Container
     * @throws DiBuilderException
     */
    public static function diContainer(): Container
    {
        if (! self::$diContainer) {
            try {
                $configDefinitions = [];

                $diConfig = array_merge(
                    $configDefinitions,
                    require __DIR__ . DIRECTORY_SEPARATOR . 'DiDefinitions.php'
                );

                self::$diContainer = (new ContainerBuilder())
                    ->useAutowiring(false)
                    ->useAnnotations(false)
                    ->addDefinitions($diConfig)
                    ->build();
            } catch (Exception $e) {
                $msg = 'Unable to build Dependency Injection Container';

                if ($e->getMessage() === 'diDefinitions must be an array') {
                    $msg = $msg . ': ' . $e->getMessage();
                }

                throw new DiBuilderException($msg, 500, $e);
            }
        }

        return self::$diContainer;
    }

    /**
     * Gets the DI Container
     * @return Container
     * @throws DiBuilderException
     */
    public function getDiContainer(): Container
    {
        return self::diContainer();
    }

    /**
     * Gets a definition
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public static function get(string $def)
    {
        try {
            return self::diContainer()->get($def);
        } catch (Exception $e) {
            $msg = 'Unable to get dependency';
            throw new DiBuilderException($msg, 500, $e);
        }
    }

    /**
     * Gets a definition
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public function getDefinition(string $def)
    {
        return self::get($def);
    }
}
