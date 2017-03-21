<?php

namespace Common\Provider;

/**
 * Http Controller for the tariff details api call
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class TariffDetails extends BaseProvider
{

    /**
     * Http Request
     *
     * @var \Zend\Http\PhpEnvironment\Request
     */
    protected $request;

    /**
     * TariffDetails constructor.
     *
     * @param \Zend\Http\PhpEnvironment\Request $request Object of the http request
     * @param \GuzzleHttp\Client $client Guzzle http client.
     * @param array|null $config Config.
     *
     * @return void
     */
    public function __construct(\Zend\Http\PhpEnvironment\Request $request, \GuzzleHttp\Client $client, array $config = null)
    {
        $this->request = $request;
        parent::__construct($client, $config);
    }

    /**
     * Return data from Api Call
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fetch ($params)
    {
        return $this->getClient()->get('tariff_detail/', ['query' => $params]);
    }

    /**
     * Get details for a single tariff, including the calculation parameter
     *
     * @param $calculationParameterId
     * @param $tariffVersionId
     * @return array Array in form:
     *               {
     *                  parameter: \classes\calculation\client\model\parameter\pkv
     *                  details:   \classes\calculation\mclient\model\tariff\pkv
     *               }
     * @throws \Exception Thrown when the JSON from API server cannot be decoded.
     * @throws \HttpResponseException Thrown when API returns anything but 200.
     */
    public function fetchParameterAndDetails($calculationParameterId, $tariffVersionId)
    {
        $config = $this->getConfig()['check24'];

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->fetch([
            'product_id' => $config['defs']['product_id'],
            'calculationparameter_id' => $calculationParameterId,
            'tariffversion_id' => $tariffVersionId,
            'tariffversion_variation_key' => 'base',
            'tracking_id' => 'checkvers',
            'partner_id' => $config['partner_id'],
            'mode_id' => 'normal',
            'promotion_type' => $this->request->getQuery()->get('promotion_type_' . $tariffVersionId),
            'is_gold_grade' => $this->request->getQuery()->get('is_gold_grade_' . $tariffVersionId)
        ]);

        if ($response->getStatusCode() == 200) {
            $details = json_decode($response->getBody()->getContents(), true);
            if (empty($details) || empty($details['data'])) {
                throw new \Exception('Error decoding JSON from API server, last error was: ' . json_last_error());
            }

        } else {
            throw new \HttpResponseException($response->getBody(), $response->getStatusCode());
        }

        return [
            'parameter' => new \classes\calculation\client\model\parameter\pkv($details['data']['parameter']),
            'details' => new \classes\calculation\mclient\model\tariff\pkv($details['data']['tariff']),
        ];

    }

}
