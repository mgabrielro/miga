<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Common\Config\ConfigAwareInterface;
use Common\Config\ConfigAwareTrait;

/**
 * Class AbstractConfig
 *
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\View\Helper
 */
abstract class AbstractConfig extends AbstractHelper implements ConfigAwareInterface
{
    use ConfigAwareTrait;

    /**
     * @var string
     */
    protected $configKey = '';

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function get($key)
    {
        return $this->getConfig()->check24
            ->get($this->configKey)
            ->get($key, '');
    }
}