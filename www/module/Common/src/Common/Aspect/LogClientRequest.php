<?php

namespace Common\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Psr\Log\LoggerInterface;

/**
 * Class LogClientRequest
 *
 * @package Common\Aspect
 * @author Alexander Roddis <alexander.roddis@check24.de>
 */
class LogClientRequest implements Aspect
{
    /**
     * @var null|LoggerInterface
     */
    protected $logger = null;

    /**
     * @var null
     */
    protected $requestId = null;

    /**
     * @param LoggerInterface $logger
     *
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Advice for logging the requests
     *
     * @param MethodInvocation $invocation Invocation
     *
     * @throws \Exception
     * @return mixed
     * @Around("execution(public shared\classes\common\rs_rest_client\rs_rest_client->send_request(*))")
     *
     */
    public function requestLoggingAdvice(MethodInvocation $invocation)
    {

        $this->requestId = uniqid("requestId-");

        try {
            $result = $invocation->proceed();
        } catch (\Exception $ex) {
            $this->logger->debug("-------REQUEST EXCEPTION - ID " . $this->requestId . " -------\n\nMessage: " . $ex->getMessage() . "\n\nTrace: " . $ex->getTraceAsString());
            throw $ex;
        }

        return $result;
    }

    /**
     * Advice for logging the requests
     *
     * @param MethodInvocation $invocation Invocation
     *
     * @throws \Exception
     * @return mixed
     * @Around("execution(protected shared\classes\common\rs_rest_client\rs_rest_client->send_socket_request(*))")
     *
     */
    public function socketRequestLoggingAdvice(MethodInvocation $invocation)
    {

        try {
            $apiHost = $invocation->getArguments()[0];
            $request = $invocation->getArguments()[1];
            $response = $invocation->proceed();
        } catch (\Exception $ex) {
            $this->logger->debug("-------INTERNAL SOCKET REQUEST EXCEPTION - ID " . $this->requestId . " -------\n\nResponseCode:".$ex->getCode()."\n\nMessage: " . $ex->getMessage() . "\n\nTrace: " . $ex->getTraceAsString());
            throw $ex;
        }

        return $response;
    }

}