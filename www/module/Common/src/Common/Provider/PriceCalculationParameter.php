<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Class PriceCalculationParameter
 *
 * @package Common\Service\Provider
 * @author Armin Beširović <armin.besirovic@check24.de>
 */
class PriceCalculationParameter extends BaseProvider
{
    /**
     * Fetch price calculation parameters, used for calculation in footnote and on Input1 for employee income threshold
     *
     * @param string $date ISO 8601 year or date
     * @param array Price calculation parameters
     * @return array
     */
    public function fetch($date)
    {
        if (strlen($date) > 4) {
            Check::is_date($date, 'year');
        } else {
            Check::is_integer($date, 'year');
        }

        $response = $this->getClient()->get('price_calculation_parameter/', ['query' => ['date' => $date]]);

        if ($response->getStatusCode() != 200) {
            return [];
        }

        $array = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() || ! isset($array['data'])) {
            return [];
        }

        return $array['data'];
    }
}