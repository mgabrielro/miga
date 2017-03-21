<?php

namespace Common\Controller;

use Common\Service\Documents\DocumentsServiceInterface;
use Common\Service\Documents\Exception\InvalidRequestException;
use Common\Service\Documents\Exception\LeadNotFoundException;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * Class MissingDocumentsController
 *
 * @package Common\Controller
 * @author Martin Rintelen <martin.rintelen@check24.de>
 *
 * @method Response createJsonResponse(array $data, $statusCode = 200)
 * @method ApiProblemResponse createApiProblemResponse($status, $detail)
 */
class MissingDocumentsController extends AbstractActionController
{
    /**
     * @var DocumentsServiceInterface
     */
    private $service;

    /**
     * @param DocumentsServiceInterface $service
     */
    public function __construct(DocumentsServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $leadHash = $this->params('leadHash');

        try {
            $missingData = $this->service->findMissing($leadHash);
        } catch (LeadNotFoundException $exception) {
            return $this->createApiProblemResponse(
                Response::STATUS_CODE_409,
                'Lead not found'
            );
        } catch (InvalidRequestException $exception) {
            return $this->createApiProblemResponse(
                Response::STATUS_CODE_500,
                'Invalid request while processing'
            );
        }

        return $this->createJsonResponse($missingData);
    }
}