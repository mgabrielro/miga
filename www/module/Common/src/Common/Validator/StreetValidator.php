<?php

namespace Common\Validator;

use C24\ZF2\User\Service\AuthenticationService;
use Common\Model\AddressService\AddressServiceModel;
use Common\Provider\AddressServiceProvider;
use Zend\Validator\AbstractValidator;

/**
 * Class StreetValidator
 *
 * @package Common\Validator
 * @author  Henrik Oelze <henrik.oelze@check24.de>
 */
class StreetValidator extends AbstractValidator
{
    /**
     * @var string
     */
    const NOT_VALID = 'notValid';

    /**
     * @var string
     */
    protected $fieldZipCode;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_VALID => self::NOT_VALID,
    ];

    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @var AddressServiceProvider
     */
    protected $addressServiceProvider;

    /**
     * StreetValidator constructor.
     *
     * @param AuthenticationService   $authenticationService
     * @param AddressServiceProvider  $addressServiceProvider
     * @param array                   $options
     */
    public function __construct(
        AuthenticationService $authenticationService,
        AddressServiceProvider $addressServiceProvider,
        array $options = []
    ) {
        parent::__construct($options);

        $this->authenticationService = $authenticationService;
        $this->addressServiceProvider  = $addressServiceProvider;
    }

    /**
     * Check if street is available in api or comes from sso account
     *
     * @param string $value
     * @param null|array $context
     *
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $valid = false;
        $this->error(static::NOT_VALID);

        $zipCode = $context[$this->fieldZipCode];
        $streetArray = $this->addressServiceProvider->fetchStreets($zipCode);

        foreach ($streetArray as $streetData) {
            /** @var $streetData AddressServiceModel */
            if ($streetData->getName() === $value) {
                $valid = true;

                return $valid;
            }
        }

        if (
            $this->authenticationService->isAuthenticated()
            && ($this->authenticationService->getUser()->getZipcode() === $zipCode)
            && ($this->authenticationService->getUser()->getStreet() === $value)
        ) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @param string $fieldZipCode
     *
     * @return StreetValidator
     */
    public function setFieldZipCode($fieldZipCode)
    {
        $this->fieldZipCode = $fieldZipCode;

        return $this;
    }
}