<?php

namespace Common\Validator\Input1;

use Common\Provider\FederalState;
use Zend\Validator\AbstractValidator;

/**
 * Class ZipcodeNotFoundFederalStateValidator
 *
 * @package Common\Validator\Input1
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class ZipcodeNotFoundFederalStateValidator extends AbstractValidator
{
    /**
     * @var FederalState
     */
    protected $federalStateProvider;

    /**
     * @var string
     */
    protected $fieldFederalState;

    /**
     * @var string
     */
    const FEDERAL_STATE_NOT_FOUND = 'federalStateNotFound';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::FEDERAL_STATE_NOT_FOUND => self::FEDERAL_STATE_NOT_FOUND,
    ];

    /**
     * @param FederalState $federalStateProvider
     * @param array $options
     */
    public function __construct(FederalState $federalStateProvider, $options = [])
    {
        parent::__construct($options);

        $this->federalStateProvider = $federalStateProvider;
    }

    /**
     * @param string $value
     * @param null|array $context
     *
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        if (!empty($context[$this->fieldFederalState])) {
            return true;
        }

        $federalStates = $this->federalStateProvider->retrieveFederalStates(
            $value
        );

        if (count($federalStates) > 0) {
            return true;
        }

        $this->error(self::FEDERAL_STATE_NOT_FOUND);

        return false;
    }

    /**
     * @param string $fieldFederalState
     *
     * @return ZipcodeNotFoundFederalStateValidator
     */
    public function setFieldFederalState($fieldFederalState)
    {
        $this->fieldFederalState = $fieldFederalState;

        return $this;
    }
}