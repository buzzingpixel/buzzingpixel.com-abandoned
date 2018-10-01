<?php
declare(strict_types=1);

namespace src\app\factories;

use Minify_HTML;

/**
 * Class CacheService
 * @untested
 */
class MinifyFactory
{
    /**
     * Creates an instance of Minify_HTML
     * @param string $html
     * @return Minify_HTML
     */
    public function make(string $html): Minify_HTML
    {
        $options = [
            'cssMinifier' => '\Minify_CSSmin::minify',
            'jsMinifier' => '\JSMin\JSMin::minify'
        ];

        return new Minify_HTML($html, $options);
    }
}
