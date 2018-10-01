<?php
declare(strict_types=1);

namespace src\app\twigextensions;

use Twig_Markup;
use Twig_Filter;
use Twig_Extension;
use craft\helpers\Template;
use src\app\services\TypesetService;
use src\app\factories\TruncationFactory;

/**
 * Class TypesetTwigExtension
 */
class TypesetTwigExtension extends Twig_Extension
{
    /** @var TypesetService $typesetService */
    private $typesetService;

    /** @var TruncationFactory $truncationFactory */
    private $truncationFactory;

    /**
     * TypesetTwigExtension constructor
     * @param TypesetService $typesetService
     * @param TruncationFactory $truncationFactory
     */
    public function __construct(
        TypesetService $typesetService,
        TruncationFactory $truncationFactory
    ) {
        $this->typesetService = $typesetService;
        $this->truncationFactory = $truncationFactory;
    }

    /**
     * Returns the twig filters
     * @return Twig_Filter[]
     */
    public function getFilters() : array
    {
        return [
            new Twig_Filter('typeset', [$this, 'typesetFilter']),
            new Twig_Filter('smartypants', [$this, 'smartypantsFilter']),
            new Twig_Filter('widont', [$this, 'widontFilter']),
            new Twig_Filter('truncate', [$this, 'truncateFilter']),
            new Twig_Filter('ucfirst', [$this, 'ucfirstFilter']),
        ];
    }

    /**
     * Runs the typeset service as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function typesetFilter(string $str): Twig_Markup
    {
        return new Twig_Markup($this->typesetService->typeset($str), 'UTF-8');
    }

    /**
     * Runs smartypants as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function smartypantsFilter(string $str): Twig_Markup
    {
        return new Twig_Markup(
            $this->typesetService->smartypants($str),
            'UTF-8'
        );
    }

    /**
     * Runs widont as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function widontFilter(string $str): Twig_Markup
    {
        return new Twig_Markup($this->typesetService->widont($str), 'UTF-8');
    }

    /**
     * Truncates HTML/text as a Twig Filter
     * @param string $val
     * @param int $limit
     * @param string $strategy Defaults to word
     * @param string $truncationString
     * @param int $minLength
     * @return Twig_Markup
     * @throws \Exception
     */
    public function truncateFilter(
        string $val,
        int $limit,
        string $strategy = 'word',
        string $truncationString = '…',
        int $minLength = 0
    ) : Twig_Markup {
        $truncation = $this->truncationFactory->make(
            $limit,
            $strategy,
            $truncationString,
            $minLength
        );

        return new Twig_Markup($truncation->truncate($val), 'UTF-8');
    }

    /**
     * Uppercases first letter
     * @param string $val
     * @return \Twig_Markup
     */
    public function ucfirstFilter(string $val) : \Twig_Markup
    {
        return new Twig_Markup(ucfirst($val), 'UTF-8');
    }
}
