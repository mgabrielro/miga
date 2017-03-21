<?php


namespace Common\Model\AddressService;

/**
 * Class AddressServiceModel
 *
 * @package Common\Model\AddressService
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class AddressServiceModel
{
    /**
     * @var string
     */
    private $areaCode;

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * @param string $areaCode
     *
     * @return AddressServiceModel
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AddressServiceModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}