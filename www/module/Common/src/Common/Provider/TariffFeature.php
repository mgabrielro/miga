<?php

namespace Common\Provider;

/**
 * Http Controller for the tariff featuretree api call
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class TariffFeature extends BaseProvider {

    /**
     * Return data from Api Call
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch ($params) {
        return $this->getClient()->get('tariff_features/', ['query' => $params]);
    }

    /**
     * Fetch feature tree for a calculation parameter and tariff version
     *
     * @param $calculationParameterId
     * @param $tariffVersionId
     * @param bool $mobile When true delivers the feature tree with only one feature group and features below it.
     * @return stdClass
     * @throws \Exception Thrown when the JSON from API server cannot be decoded.
     * @throws \HttpResponseException Thrown when API returns anything but 200.
     */
    public function fetchFeatures($calculationParameterId, $tariffVersionId, $mobile = false)
    {
        $config = $this->getConfig()['check24'];

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->fetch([
            'product_id'              => $config['defs']['product_id'],
            'calculationparameter_id' => $calculationParameterId,
            'tariffversion_id'        => $tariffVersionId,
            'show_mobile'             => $mobile ? 'yes' : 'no',
        ]);

        if ($response->getStatusCode() == 200) {
            $features = json_decode($response->getBody()->getContents(), true);

            if (empty($features) || empty($features['data'])) {
                throw new \Exception('Error decoding JSON from API server, last error was: ' . json_last_error());
            }
        } else {
            throw new \HttpResponseException($response->getBody()->getContents(), $response->getStatusCode());
        }

        return $features['data'];
    }
}
