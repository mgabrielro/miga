<?php

namespace Common\Provider;

/**
 * Http Controller for sending the result page info per received email
 *
 * @package Common\Service\Provider
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class CountFavorite extends BaseProvider {

    /**
     * Return data from Api Call
     *
     * @param array  $parameters   The needed parameters to be sent on API request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch (array $parameters = []) {

        $calculationparameter_id = !empty(trim($parameters['calculationparameter_id']))
            ? htmlspecialchars($parameters['calculationparameter_id'])
            : 'false';

        $pkvfavorites_token      = !empty($parameters['pkvfavorites_token'])
            ? htmlspecialchars($parameters['pkvfavorites_token'])
            : 0;

        $deviceoutput            = !empty($parameters['deviceoutput'])
            ? htmlspecialchars($parameters['deviceoutput'])
            : 'mobile';

        $endpoint = 'favorite/count/' . $calculationparameter_id . '/' . $pkvfavorites_token . '/' . $deviceoutput;

        return $this->getClient()->get($endpoint);

    }

}