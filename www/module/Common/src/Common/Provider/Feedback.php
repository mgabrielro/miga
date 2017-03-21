<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Class Feedback
 *
 * @package Common\Service\Provider
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Feedback extends BaseProvider
{
    /**
     * fetch available Cities from API. Used for Autocomplete
     *
     * @param integer $zipcode The Requested Zipcode
     * @param boolean $short_city Short city
     * @return \shared\classes\calculation\client\response
     */
    public function fetch($product_id, $provider_id, $offset = 0, $limit = 5)
    {
        Check::is_integer($product_id, 'product_id');
        Check::is_integer($provider_id, 'provider_id');
        Check::is_integer($offset, 'offset', true);
        Check::is_integer($limit, 'limit');

        $endpoint = 'customerfeedback/' . $product_id . '/' . $provider_id . '/';

        $parameters = [
            'offset' => $offset,
            'limit' => $limit,
        ];

        return $this->getClient()->get($endpoint, ['query' => $parameters]);
    }
}