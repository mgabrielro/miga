<?php

namespace Common\Register\Service;

use Common\Exception\RemoteException;
use Common\Register\Exception\InvalidContainerIdException;
use Common\Register\Model\Factory\RegisterModelFactory;
use Common\Register\Model\RegisterModel;
use Common\Register\Provider\RegisterProvider;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Zend\Http\Response;
use Zend\Hydrator\HydratorInterface;
use Zend\Json\Json;

/**
 * Class RegisterModelService
 *
 * @package Common\Register\Service
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterModelService implements RegisterModelServiceInterface
{
    /**
     * @var RegisterProvider
     */
    protected $provider;

    /**
     * @var RegisterModelFactory
     */
    protected $modelFactory;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param RegisterProvider     $provider
     * @param RegisterModelFactory $modelFactory
     * @param HydratorInterface    $hydrator
     */
    public function __construct(
        RegisterProvider $provider,
        RegisterModelFactory $modelFactory,
        HydratorInterface $hydrator
    ) {
        $this->provider = $provider;
        $this->modelFactory = $modelFactory;
        $this->hydrator = $hydrator;
    }

    /**
     * @param array $data
     *
     * @return object|RegisterModel
     */
    public function createModel(array $data)
    {
        return $this->hydrator->hydrate(
            $data,
            $this->modelFactory->create()
        );
    }

    /**
     * @param string $registerContainerId
     * @param string $step
     *
     * @throws RemoteException
     * @return RegisterModel|object
     */
    public function fetchModel($registerContainerId, $step)
    {
        $modelData = [];

        try {
            $modelData = $this->provider->fetchStepDefinition(
                $registerContainerId,
                $step
            );
        } catch (ClientException $clientException) {
            $this->handleClientException($clientException);
        } catch (BadResponseException $responseException) {
            throw new RemoteException(
                $responseException->getMessage(),
                false,
                $responseException->getCode(),
                $responseException
            );
        }

        return $this->createModel(
            $modelData
        );
    }

    /**
     * @param ClientException $clientException
     *
     * @throws InvalidContainerIdException
     * @throws ClientException
     * @return void
     */
    protected function handleClientException(ClientException $clientException)
    {
        if ($clientException->getCode() !== Response::STATUS_CODE_400) {
            throw $clientException;
        }

        $exceptionData = Json::decode(
            $clientException->getResponse()->getBody()->getContents(),
            Json::TYPE_ARRAY
        );

        if (!isset($exceptionData['data'])) {
            throw $clientException;
        }

        if (isset($exceptionData['data']['registercontainer_id'])) {
            throw new InvalidContainerIdException(
                $exceptionData['data']['registercontainer_id']
            );
        }

        throw $clientException;
    }
}