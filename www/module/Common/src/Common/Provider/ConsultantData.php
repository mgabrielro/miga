<?php

namespace Common\Provider;

/**
 * Http Controller for thank you page get consultant data if family matching is success
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class ConsultantData extends BaseProvider {

    /**
     * Return data from Api Call
     *
     * @param string $lead_id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch ($lead_id) {
        return $this->getClient()->get('mobile/consultant_data/' . $lead_id);
    }

}
