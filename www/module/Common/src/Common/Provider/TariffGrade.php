<?php

namespace Common\Provider;

/**
 * Http Controller for the tariff grade api call
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class TariffGrade extends BaseProvider {

    /**
     * Return data from Api Call
     *
     * @param integer $tariff_version_id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch ($tariff_version_id) {
    
        return $this->getClient()->get('tariffgrades/' . $tariff_version_id);
    
    }

}