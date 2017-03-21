<?php
namespace Common\Service;

use Zend\Http\Request;

/**
 * Determines the active device output
 *
 * @author Robert Curth <robert.curth@check24.de>
 * @author Jaha Deliu <jaha.deliu@check24.de>
 */
class DeviceOutput {
    /**
     * Default device output
     * @var string
     */
    protected $default;

    /**
     * All whitelisted device outputs
     * @var array
     */
    protected $whitelisted_outputs;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     * @param DeviceType $type
     * @param array $config
     */
    public function __construct(Request $request, DeviceType $type, $config) {
        $this->request = $request;
        $this->device_type = $type;
        $this->whitelisted_outputs = $config['whitelisted'];
        $this->default = $config['default'];
    }

    /**
     * Gets the current deviceoutput
     *
     * @return string
     */
    public function get() {
        $get_param = $this->request->getQuery('deviceoutput', '');

        if($this->isWhitelistedOutput($get_param)) {
            return $get_param;
        }

        $cookies = $this->request->getCookie();

        if(isset($cookies[ 'deviceoutput' ]) && $this->isWhitelistedOutput($cookies[ 'deviceoutput' ])) {
            return $cookies[ 'deviceoutput' ];
        }


        $type = $this->device_type->get();
        if($this->isWhitelistedOutput($type)) {
            return $type;
        }

        return $this->default;
    }


    /**
     * Checks if deviceoutput is whitelisted
     *
     * @param string $output The device output
     *
     * @return boolean
     */
    protected function isWhitelistedOutput($output) {
        return in_array($output, $this->whitelisted_outputs, true);
    }
}
