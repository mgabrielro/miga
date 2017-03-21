<?php

namespace Common\Aop\Feature;

/**
 * Interface AspectProviderInterface
 *
 * @package Common\Aop\Feature
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
interface AspectProviderInterface
{
    public function getAspectConfig();
}