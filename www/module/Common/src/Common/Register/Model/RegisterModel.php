<?php

namespace Common\Register\Model;

use Common\Calculation\Model\Parameter\User;
use Common\Calculation\Model\Tariff\Gkv;

/**
 * Class RegisterModel
 *
 * @package Common\Register\Model
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterModel
{
    /**
     * @var array
     */
    private $stepInformation;

    /**
     * @var array
     */
    private $formDefinition;

    /**
     * @var array
     */
    private $steps;

    /**
     * @var User
     */
    private $calculationparameter;

    /**
     * @var Gkv
     */
    private $registertariff;

    /**
     * @var int
     */
    private $resultPosition;

    /**
     * This method is adopted from registermanager.class.php:115.
     * It might be removed if all forms are zend forms.
     *
     * @deprecated
     * @return array
     */
    public function extractFormData()
    {
        $formData = [];

        foreach ($this->formDefinition as $key => $field) {
            $formData[$key] = $field['display_data'];
        }

        return $formData;
    }

    /**
     * @return array
     */
    public function getStepInformation()
    {
        return $this->stepInformation;
    }

    /**
     * @param array $stepInformation
     * @return RegisterModel
     */
    public function setStepInformation(array $stepInformation)
    {
        $this->stepInformation = $stepInformation;

        return $this;
    }

    /**
     * @return array
     */
    public function getFormDefinition()
    {
        return $this->formDefinition;
    }

    /**
     * @param array $formDefinition
     * @return RegisterModel
     */
    public function setFormDefinition(array $formDefinition)
    {
        $this->formDefinition = $formDefinition;

        return $this;
    }

    /**
     * @return array
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param array $steps
     * @return RegisterModel
     */
    public function setSteps(array $steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * @return User
     */
    public function getCalculationparameter()
    {
        return $this->calculationparameter;
    }

    /**
     * @param User $calculationparameter
     * @return RegisterModel
     */
    public function setCalculationparameter(User $calculationparameter)
    {
        $this->calculationparameter = $calculationparameter;

        return $this;
    }

    /**
     * @return Gkv
     */
    public function getRegistertariff()
    {
        return $this->registertariff;
    }

    /**
     * @param Gkv $registertariff
     *
     * @return RegisterModel
     */
    public function setRegistertariff(Gkv $registertariff)
    {
        $this->registertariff = $registertariff;

        return $this;
    }

    /**
     * @return int
     */
    public function getResultPosition()
    {
        return $this->resultPosition;
    }

    /**
     * @param int $resultPosition
     * @return RegisterModel
     */
    public function setResultPosition($resultPosition)
    {
        $this->resultPosition = $resultPosition;

        return $this;
    }
}