<?php

namespace Common\Register\Model\Factory;

use Common\Register\Model\RegisterModel;

/**
 * Class RegisterModelFactory
 *
 * @package Common\Register\Model\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterModelFactory
{
    /**
     * @return RegisterModel
     */
    public function create()
    {
        return new RegisterModel();
    }
}