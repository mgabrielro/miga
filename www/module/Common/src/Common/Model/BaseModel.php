<?php

namespace Common\Model;

/**
 * Class JsonResponse
 *
 * @package Common\Model
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
abstract class BaseModel
{
    /**
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->setProperties($response);
    }

    /**
     * @param mixed $response
     */
    public function setProperties($response)
    {
        $json = is_array($response) ? $response : json_decode($response, true);

        foreach($json as $key => $value)
        {
            if(\property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}