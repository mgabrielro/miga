<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Class City
 *
 * @package Common\Service\Provider
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class City extends BaseProvider
{
    /**
     * fetch available Cities from API. Used for Autocomplete
     *
     * @param integer $zipcode The Requested Zipcode
     * @param boolean $short_city Short city
     * @return \shared\classes\calculation\client\response
     */
    public function fetch($zipcode, $short_city = true)
    {
        Check::is_string($zipcode, 'zipcode');
        Check::is_boolean($short_city, 'short_city');

        $parameters = [
            'zipcode' => $zipcode,
            'short_city' => $short_city == true ? 'yes' : 'no'
        ];

        return $this->getClient()->get('cities/', ['query' => $parameters]);
    }
}