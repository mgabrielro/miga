<?php

namespace Common\Provider;

use Common\Validator\Check;

/**
 * Http Controller for sending the result page info per received email
 *
 * @package Common\Service\Provider
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class SendResultsPerEmail extends BaseProvider {

    /**
     * Return data from Api Call
     *
     * @param array  $parameters   The needed parameters to be sent on API request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch (array $parameters = []) {
        return $this->getClient()->request('post', 'mailer/result_page/', ['form_params' => $parameters]);
    }

}