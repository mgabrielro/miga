<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Class City
 *
 * @package Common\Service\Provider
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Street extends BaseProvider
{
    /**
     * fetch available Cities from API. Used for Autocomplete
     *
     * @param string $snippet The Requested Zipcode
     * @param boolean $short_city Short city
     * @return \shared\classes\calculation\client\response
     */
    public function fetch($zipcode, $city = '', $short_city = true)
    {
        Check::is_string($zipcode, 'zipcode');
        Check::is_string($city, 'city', true);
        Check::is_boolean($short_city, 'short_city');

        $parameters = ['zipcode' => $zipcode];

        if ($city != '') {
            $parameters['city'] = $city;
            $parameters['short_city'] = $short_city == true ? 'yes' : 'no';
        }

        return $this->getClient()->get('streets/', ['query' => $parameters]);
    }
}