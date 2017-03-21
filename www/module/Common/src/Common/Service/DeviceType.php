<?php
namespace Common\Service;

use C24Wurfl\Service\WurflService;
use Zend\Http\Request;
use \shared\classes\common\exception;

/**
 * Determines the active device type
 *
 * @author Robert Curth <robert.curth@check24.de>
 */
class DeviceType {
    const DESKTOP = 'desktop';
    const MOBILE = 'mobile';
    const TABLET = 'tablet';

    /**
     * All whitelisted device outputs
     * @var array
     */
    public static $whitelisted_types = [
        self::DESKTOP,
        self::MOBILE,
        self::TABLET
    ];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var WurflService
     */
    protected $wurfl;

    /**
     * @param Request $request
     * @param WurflService $wurfl
     */
    public function __construct(Request $request, WurflService $wurfl) {
        $this->request = $request;
        $this->wurfl = $wurfl;
    }

    /**
     * Gets the current device type
     *
     * @throws exception\logic In case $request dependency was not injected
     *
     * @return string
     */
    public function get() {
        $get_param = $this->request->getQuery('devicetype', '');

        if($this->isWhitelistedType($get_param)) {
            return $get_param;
        }

        $cookies = $this->request->getCookie();

        if(isset($cookies[ 'devicetype' ]) && $this->isWhitelistedType($cookies[ 'devicetype' ])) {
            return $cookies[ 'devicetype' ];
        }

        return $this->getWurflOutput();

    }

    /**
     * Detect the device type using WURFL and map it onto
     * our own device types
     *
     * @return string
     */
    protected function getWurflOutput() {
        $wurfl_type = $this->wurfl->getDeviceType();

        switch($wurfl_type) {
            case WurflService::PHONE_TYPE:
            case WurflService::WIRELESS_TYPE:
                return self::MOBILE;
            case WurflService::TABLET_TYPE:
                return self::TABLET;
            default:
                return self::DESKTOP;
        }
    }

    /**
     * Checks if type is whitelisted
     *
     * @param string $output The device output
     *
     * @return boolean
     */
    protected function isWhitelistedType($type) {
        return in_array($type, self::$whitelisted_types, true);
    }
}
