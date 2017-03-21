<?php

namespace Common\View\Helper;

use Zend\Uri\UriFactory;
use Zend\View\Helper\AbstractHelper;

/**
 * Class SvgSpriteIcon
 *
 * @package Common\View\Helper
 * @author  Markus Lommer <markus.lommer@check24.de>
 */
class SvgSpriteIcon extends AbstractHelper
{
    /**
     * @var string
     */
    const TEMPLATE = <<<SVG_TAG
<svg%s>
     <use xlink:href="%s"></use>
</svg>
SVG_TAG;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var string
     */
    protected $svgSpritePath;

    /**
     * BustedSvgTag constructor.
     *
     * @param string $cacheKey
     * @param string $svgSpritePath
     */
    public function __construct(
        $cacheKey,
        $svgSpritePath
    ) {
        $this->cacheKey      = $cacheKey;
        $this->svgSpritePath = $svgSpritePath;
    }

    /**
     * Render svg tag with busted uri and class.
     *
     * @param string $fragment
     * @param array  $classes
     *
     * @return string
     */
    public function __invoke($fragment, $classes = [])
    {
        $href = $this->svgSpritePath . $fragment;

        $params = [
            'v' => $this->cacheKey,
        ];

        $bustedSvgHref = $this->attachQueryParametersToHref($href, $params);

        return $this->render($bustedSvgHref, $classes);
    }

    /**
     * Modify query string with additional parameters.
     *
     * @param string $href
     * @param array  $params
     *
     * @return string
     */
    protected function attachQueryParametersToHref($href, array $params)
    {
        $href = UriFactory::factory($href);

        $queryParams = $href->getQueryAsArray();

        if (!empty($queryParams)) {
            $params = array_merge($params, $queryParams);
        }

        $href->setQuery($params);

        return $href->toString();
    }

    /**
     * Render the tag.
     *
     * @param string $bustedSvgHref
     * @param array  $classes
     *
     * @return string
     */
    public function render($bustedSvgHref, $classes = [])
    {
        $classString = '';

        if (!empty($classes)) {
            $classString = ' class="' . implode(' ', $classes) . '"';
        }

        return sprintf(
            static::TEMPLATE,
            $classString,
            $bustedSvgHref
        );
    }
}