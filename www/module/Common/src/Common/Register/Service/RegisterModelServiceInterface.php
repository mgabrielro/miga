<?php

namespace Common\Register\Service;

use Common\Register\Model\RegisterModel;

/**
 * Interface RegisterModelServiceInterface
 *
 * @package Common\Register\Service
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
interface RegisterModelServiceInterface
{
    /**
     * @param array $data
     *
     * @return RegisterModel
     */
    public function createModel(array $data);


    /**
     * @param string $registerContainerId
     * @param string $step
     *
     * @return RegisterModel
     */
    public function fetchModel($registerContainerId, $step);
}