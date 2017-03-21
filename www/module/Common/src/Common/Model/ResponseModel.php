<?php

namespace Common\Model;

/**
 * Class JsonResponse
 *
 * @package Common\Model
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ResponseModel extends BaseModel
{
    /**
     * @var integer
     */
    protected $status_code;

    /**
     * @var string
     */
    protected $status_message;

    /**
     * @var string
     */
    protected $data;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param int $status_code
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->status_message;
    }

    /**
     * @param string $status_message
     */
    public function setStatusMessage($status_message)
    {
        $this->status_message = $status_message;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}