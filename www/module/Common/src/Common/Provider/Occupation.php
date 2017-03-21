<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Class Occupation
 *
 * @package Common\Service\Provider
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Occupation extends BaseProvider
{
    /**
     * Fetch available Occupations from API. Used for Autocomplete
     *
     * @param string $snippet The Requested Zipcode
     * @param boolean $short_city Short city
     * @return \shared\classes\calculation\client\response
     */
    public function fetch($snippet, $limit = 10)
    {
        Check::is_string($snippet, 'snippet');
        Check::is_integer($limit, 'limit');

        return $this->getClient()->get('occupation/name/' . urlencode($snippet) . '/' . $limit . '/');

    }
}