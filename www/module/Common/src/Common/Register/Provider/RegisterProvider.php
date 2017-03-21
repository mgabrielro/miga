<?php

namespace Common\Register\Provider;

use C24\ZF2\User\Service\AuthenticationService;
use Common\Provider\BaseProvider;
use GuzzleHttp\Client;
use Zend\Json\Json;
use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;
use Zend\Hydrator\HydratorInterface;

/**
 * Class RegisterProvider
 *
 * @package Common\Register\Provider
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterProvider extends BaseProvider implements HydratorAwareInterface
{
    use HydratorAwareTrait;

    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @param Client                $client
     * @param array                 $clientOptions
     * @param HydratorInterface     $hydrator
     * @param AuthenticationService $authenticationService
     */
    public function __construct(
        Client $client,
        array $clientOptions = [],
        HydratorInterface $hydrator,
        AuthenticationService $authenticationService
    ) {
        parent::__construct($client, $clientOptions);

        $this->setHydrator($hydrator);
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param string $registerContainerId
     * @param string $step
     *
     * @return array
     */
    public function fetchStepDefinition($registerContainerId, $step)
    {
        $response = $this->getClient()->request(
            'get',
            'registergkv/',
            array_merge(
                $this->clientOptions,
                [
                    'query' => [
                        'registercontainer_id' => $registerContainerId,
                        'step'                 => $step,
                        'c24login_session_id'  => $this->authenticationService->getToken(),
                    ],
                ]

            )
        );

        $responseData = Json::decode(
            $response->getBody()->getContents(),
            Json::TYPE_ARRAY
        );

        return $responseData['data'];
    }
}