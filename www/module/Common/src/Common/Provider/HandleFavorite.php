<?php

namespace Common\Provider;

/**
 * Http Controller for sending the result page info per received email
 *
 * @package Common\Service\Provider
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class HandleFavorite extends BaseProvider {

    const ADD    = 'add_favorite';
    const DELETE = 'delete_favorite';

    /**
     * Return data from Api Call
     *
     * @param array  $parameters   The needed parameters to be sent on API request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch (array $parameters = []) {

        $action = isset($parameters['favorite_action'])
            ? htmlspecialchars($parameters['favorite_action'])
            : '';

        $endpoint = 'favorite/' . $action;

        if (in_array($parameters['favorite_action'], [self::ADD, self::DELETE])) {
            unset($parameters['favorite_action']);
        }

        switch ($action) {

            case self::ADD:
                return $this->getClient()->request('post', $endpoint, ['form_params' => $parameters]);
                break;

            case self::DELETE:
                $endpoint .= '/' . $parameters['tariffversion_id'] . '/' . $parameters['pkvfavorites_token'];
                break;

            default:

                // In case of an ACTIVATE / DEACTIVATE action the id will hold the DB favorite record id
                if (isset($parameters['id'])) {
                    $endpoint .= '/' . (int)($parameters['id']);
                }

        }

        return $this->getClient()->get($endpoint);

    }

}