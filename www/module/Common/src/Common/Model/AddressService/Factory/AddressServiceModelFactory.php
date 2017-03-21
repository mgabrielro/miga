<?php

namespace Common\Model\AddressService\Factory;

use Common\Model\AddressService\AddressServiceModel;

/**
 * Class AddressServiceModelFactory
 *
 * @package Common\Model\AddressService\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class AddressServiceModelFactory
{
    /**
     * @return AddressServiceModel
     */
    public function __invoke()
   {
       return new AddressServiceModel();
   }
}