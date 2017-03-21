<?php

namespace Common\View\Helper\Factory;

use Cache\Service\CacheBustingKeyService;
use Common\View\Helper\SvgSpriteIcon;
use VV\ZF\C24\Config\Config;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class SvgSpriteIconFactory
 *
 * @package Common\View\Helper\Factory
 * @author  Markus Lommer <markus.lommer@check24.de>
 */
class SvgSpriteIconFactory
{
    /**
     * @param AbstractPluginManager $pluginManager
     *
     * @return SvgSpriteIcon
     */
    public function __invoke(AbstractPluginManager $pluginManager)
    {
        $serviceLocator = $pluginManager->getServiceLocator();

        $cacheKey = $serviceLocator
            ->get(CacheBustingKeyService::class)
            ->getCacheKey();

        $svgSpritePath = $serviceLocator
            ->get(Config::class)
            ->check24
            ->svg_sprite_path;

        return new SvgSpriteIcon(
            $cacheKey,
            $svgSpritePath
        );
    }
}
