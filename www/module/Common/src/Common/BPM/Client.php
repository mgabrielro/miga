<?php

namespace Common\BPM;

use GuzzleHttp\Exception\ClientException;

/**
 * Best Prefilling Management API Client
 *
 * This client takes care of saving and retrieving entries from the BPM database,
 * It will also take care of field-name conversions for you (between SSO names and PKV field names).
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 */
class Client
{
    /**
     * Default cookie expiry in seconds (def. 30 days)
     */
    const COOKIE_EXPIRE = 2592000;

    /**
     * SSO Service ID
     *
     * @var int
     */
    private $service_id;

    /**
     * Secret key used with the BPM API
     *
     * This is most likely the same for the SSO API.
     *
     * @var string
     */
    private $secret;

    /**
     * Product key in lowercase
     *
     * @var string
     */
    private $product_key;

    /**
     * HTTP client used for calls to API
     *
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * Cookie domain
     *
     * @var string
     */
    private $cookie_domain;

    /**
     * Mapping of SSO field names (keys) to PKV/PV field names (values)
     *
     * Please note that this also defines the fields that will be synced. In other words, if you want to automatically
     * add a field that is on the input1 or register pages, simply add it to this list.
     *
     * @var array
     */
    private $fieldMap = [
        'person_birthday'   => 'c24api_birthdate',
        'pkv_profession'    => 'c24api_profession',
        'address_zipcode'   => 'zipcode',
        'address_city'      => 'city',
        'address_area_code' => 'phoneprefix',
    ];

    /**
     * Client constructor.
     *
     * @param $service_id
     * @param $secret
     * @param $product_key
     * @param $httpClient
     */
    public function __construct(
        $service_id,
        $secret,
        $product_key,
        $cookie_domain,
        $httpClient
    )
    {
        $this->service_id = $service_id;
        $this->secret = $secret;
        $this->product_key = $product_key;
        $this->cookie_domain = $cookie_domain;
        $this->httpClient = $httpClient;
    }

    /**
     * Get cookie domain
     *
     * @return string
     */
    public function getCookieDomain()
    {
        return $this->cookie_domain;
    }

    /**
     * Set cookie domain
     *
     * @param string $cookie_domain
     */
    public function setCookieDomain($cookie_domain)
    {
        $this->cookie_domain = $cookie_domain;
        return $this;
    }

    /**
     * Get service_id
     *
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Get service_id
     *
     * @param mixed $service_id
     * @return Client
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
        return $this;
    }

    /**
     * Get secret
     *
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set secret
     *
     * @param mixed $secret
     * @return Client
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * Get product key
     *
     * @return mixed
     */
    public function getProductKey()
    {
        return $this->product_key;
    }

    /**
     * Set product key
     *
     * @param mixed $product_key
     * @return Client
     */
    public function setProductKey($product_key)
    {
        $this->product_key = mb_strtolower($product_key);
        return $this;
    }

    /**
     * BPM API GET call, retrieves key-values for $hash
     *
     * Note that this method will take care of field name transformations, please do no do them yourself!
     *
     * @param $hash
     * @return array
     */
    public function get($hash)
    {
        try {
            $response = $this->httpClient->request('GET', 'get', [
                'query' => [
                    'hash' => $hash,
                    'api_service' => $this->service_id,
                    'api_secret' => $this->secret,
                    'api_product' => $this->product_key,
                ]
            ]);
        } catch (ClientException $e) {
            return [];
        }

        if ($response->getStatusCode() != 200) {
            return [];
        }

        $data = json_decode($response->getBody(), true);

        if (empty($data) || !is_array($data) || empty($data['api_data'])) {
            return [];
        }

        // Remove the MongoDB row ID

        if (! empty($data['api_data']['_'])) {
            unset($data['api_data']['_']);
        }

        return $this->mapFields($data['api_data'], $this->fieldMap);
    }

    /**
     * BPM API SET call - stores key-value pairs to the BPM database
     *
     * Note that this method will take care of field name transformations, please do no do them yourself!
     *
     * @param $hash
     * @param array $data
     * @return bool
     */
    public function set($hash, array $data = [])
    {
        try {
            $response = $this->httpClient->request('GET', 'set', [
                'query' => array_merge($this->mapFields($data, array_flip($this->fieldMap)), [
                    'hash' => $hash,
                    'api_service' => $this->service_id,
                    'api_secret' => $this->secret,
                    'api_product' => $this->product_key,
                ])
            ]);
        } catch (ClientException $e) {
            return false;
        }

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $data = json_decode($response->getBody(), true);

        if (empty($data) || !is_array($data) || empty($data['status'])) {
            return false;
        }

        return $data['status'] == 'ok';
    }

    /**
     * Apply name-transformations based on $map to $array
     *
     * @param array $array
     * @param array $map
     * @return array
     */
    private function mapFields(array $array, array $map)
    {
        $mapped = [];

        foreach ($array AS $key => $value) {

            if (isset($map[$key])) {
                $mapped[$map[$key]] = $value;
            } else {
                $mapped[$key] = $value;
            }

        }

        return $mapped;
    }

    /**
     * Get field mapping array
     *
     * @return array
     */
    public function getFieldMap()
    {
        return $this->fieldMap;
    }

}
