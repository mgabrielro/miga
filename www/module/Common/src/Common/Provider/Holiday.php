<?php

namespace Common\Provider;

/**
 * Get the Informations about a Day on the country germany in the region bavaria
 * This call returns follow informations of the day:
 *  - Is holiday on this day
 *  - Is this day on weekend
 *  - Is the time in worktime (10 - 18)
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class Holiday extends BaseProvider {

    const COUNTRY = 'de';

    const REGION = 'by';


    /**
     * Return data from Api Call
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch ($params) {
        return $this->getClient()->get('holiday/day/' . $params['day'] . '/' . $params['month'] . '/'
            . $params['year'] . '/' . self::COUNTRY . '/' . self::REGION .'/');
    }

}
