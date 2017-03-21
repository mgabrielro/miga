<?php

namespace Common\Controller;

use C24Efeedback\Service\FeedbackService;
use Common\Model\ResponseModel;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Zend\View\Model\JsonModel;
use Common\Validator\Check;

/**
 * Class AjaxController
 *
 * @package Common\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AjaxController extends BaseController
{
    /**
     * Get available Occupations by snipped
     *
     * @return JsonModel
     */
    public function getOccupationAction()
    {
        /** @var string $snippet The Occupation snippet word to search for */
        $snippet = $this->getParam('snippet');

        /** @var integer $limit how many results to view */
        $limit = $this->getParam('limit', 7);

        /** @var ResponseInterface $response Get API Response */
        $response = $this->get('Common\Provider\Occupation')->fetch($snippet, $limit);

        /** return json model */
        return $this->getJsonModel($response);
    }

    /**
     * It brings the eFeedbacks from efeedback-provider
     *
     * @return JsonModel
     */
    public function getFeedbackAction()
    {
        /** @var array $params */
        $params = $this->getEvent()->getRouteMatch()->getParams();

        /** @var integer $stars */
        $stars = $this->getQuery('stars', 0);

        /** @var FeedbackService $client */
        $client = $this->getServiceLocator()->get('CustomerReviewService');

        $query = array(
            'limit' => (int) $this->getRequest()->getQuery('limit', 5),
            'offset' => (int) $this->getRequest()->getQuery('offset', 0)
        );

        if($stars != 0) {
            $query['min_rate'] = ($stars * 2) - 1;
            $query['max_rate'] = ($stars * 2);
        }

        $data = $client->get_customer_reviews($params['provider_id'], $query);

        $results = [];
        foreach($data as $comment)
        {
            array_push($results, [
                'created_at'      => $comment->created_at,
                'customer_name'   => $comment->customer_name,
                'rating'          => $comment->rating,
                'comment_negativ' => $comment->comment_negative,
                'comment_positiv' => $comment->comment_positive,
            ]);
        }

        return $this->getJsonModel($results);
    }

    /**
     * Get the tariff grades from api and prepare the data for frontend
     *
     * @return JsonModel
     */
    public function getTariffGradeAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();
        $client = $this->get('Common\Provider\TariffGrade')->fetch($params['calculationparameter']);

        $model = new ResponseModel($client->getBody()->getContents());
        $temp = array();
        $grades = $model->getData()['grades'];
        $score = $model->getData()['scores'];

        foreach ($score['groups'] as $key => $value) {

            if (isset($grades[$key])) {
                $temp[$key] = array_merge($value,array('grade' => $grades[$key]));
            }

        }

        return $this->getJsonModel($temp);

    }

    /**
     * Convert a string with decimal in number with no decimal and return a string
     *
     * @param string $string_with_number
     * @return string $limit
     */
    private function format_german_currency($string_with_number) {

        $string_with_number = trim($string_with_number);

        $pos_limit = strpos($string_with_number, '€');
        $is_space = strpos($string_with_number, ' ');

        if ($pos_limit !== false){

            if ($is_space !== false){

                $str_limit           = $string_with_number;
                $explode_limit       = explode(' ', $str_limit, 2);
                $string_with_number  = (int)$explode_limit[0];

                if (isset($explode_limit[1])){
                    $string_with_number .= ' ' . $explode_limit[1];
                }

            } else {
                $string_with_number = (int)(str_replace('€','',$string_with_number)) . ' €';
            }

        }

        return $string_with_number;

    }

    /**
     * Get the tariff details from Api and remove unused information
     *
     * @return JsonModel
     */
    public function getTariffDetailsAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();
        unset($params['controller']);
        unset($params['action']);
        $params['product_id'] = $this->getProductId();
        $client = $this->get('Common\Provider\TariffDetails')->fetch($params);

        $model = new ResponseModel($client->getBody()->getContents());
        $data = $model->getData();
        $product_depentent_features = $data['tariff']['tariff']['product_dependent_features'];

        //Extra for hospital payout
        $params['hospital_payout_amount'] = $data['parameter']['pdhospital_payout_amount_value'];
        $params['hospital_payout_start'] = $data['parameter']['pdhospital_payout_start'];

        if ($product_depentent_features['provision_healthy_lifestyle_bonus'] == 'yes') {

            $params['savings']['lifestyle']['comment'] = $product_depentent_features['provision_healthy_lifestyle_bonus_comment'];

            $string_lifestyle_limit_number = $this->format_german_currency($product_depentent_features['provision_healthy_lifestyle_bonus_limit']);
            $params['savings']['lifestyle']['limit'] = 'Bis zu ' . $string_lifestyle_limit_number . ' pro Jahr';

        }

        if ($product_depentent_features['provision_contribution_reimbursement'] == 'yes') {

            $params['savings']['garanty_refund']['comment'] = $product_depentent_features['provision_contribution_reimbursement_comment'];
            $params['savings']['garanty_refund']['limit'] = $product_depentent_features['provision_contribution_reimbursement_limit'];

        }

        if ((int) $product_depentent_features['provision_contribution_reimbursement_amount_limit'] > 0) {

            $params['savings']['variable_refund']['first_y'] = $product_depentent_features['provision_contribution_reimbursement_amount_1y'];
            $params['savings']['variable_refund']['limit']   = 'max. ' . $product_depentent_features['provision_contribution_reimbursement_amount_limit'];
            $params['savings']['variable_refund']['comment'] = $product_depentent_features['provision_contribution_reimbursement_amount_comment'];

        }

        if ($product_depentent_features['provision_contribution_reimbursement_child'] == 'no'
            && $data['parameter']['insured_person'] == \classes\calculation\client\model\parameter\pkv::INSURED_PERSON_CHILD) {
            $params['savings']['provision_refund_child']['comment'] = $product_depentent_features['provision_contribution_reimbursement_child_comment'];
            $params['savings']['provision_refund_child']['limit'] = '';
        }

        $params['paymentperiod'] = $data['tariff']['paymentperiod'];
        $params['price'] = $data['tariff']['price'];

        return $this->getJsonModel($params);

    }

    /**
     * Get all tariff features for mobile from Api
     *
     * @return JsonModel
     */
    public function getTariffFeatureAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();
        unset($params['controller']);
        unset($params['action']);
        $params['product_id'] = $this->getProductId();
        $params['show_mobile'] = 'yes';
        $params['extra_mobile_tooltip'] = 'yes';

        $client = $this->get('Common\Provider\TariffFeature')->fetch($params);
        $model = new ResponseModel($client->getBody()->getContents());
        $data = $model->getData();

        return $this->getJsonModel($data);
    }

    /*
     * If the date is correct, no holidays and no weekend and is in worktime (10-18) we get the consultant Data form Api
     * On the Lead id we found on thank you page
     *
     * @return JsonModel
     */
    public function getConsultantDataAction() {

        $return = array(
            'success' => false,
            'consultant' => array()
        );
        $date = $this->getDateInformationAction();

        if ($date['is_weekday'] && $date['is_holiday'] == false && $date['is_worktime']) {

            $params = $this->getEvent()->getRouteMatch()->getParams();
            $client = $this->get('Common\Provider\ConsultantData')->fetch($params['lead_id']);
            $model = new ResponseModel($client->getBody()->getContents());
            return $this->getJsonModel($model->getData());

        } else {
            return $this->getJsonModel($return);
        }

    }

    /**
     * Get the Date Information (weekend, holidays, working time)
     *
     * @return array
     */
    public function getDateInformationAction() {

        $date = new \DateTime();
        $params['year'] = $date->format('Y');
        $params['month'] = $date->format('m');
        $params['day'] = $date->format('d');

        $client = $this->get('Common\Provider\Holiday')->fetch($params);
        $model = new ResponseModel($client->getBody()->getContents());
        return $model->getData();

    }

    /**
     * Send the needed info to our Core-API, in order to send the Result Page infos per Email
     *
     * @return JsonModel
     */
    public function getSendResultsPerEmailAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();

        unset($params['controller']);
        unset($params['action']);

        $params['is_mobile_request'] = true;
        $params['session_id']        = '';

        $cookie = $this->getRequest()->getCookie();

        if ($cookie && $cookie->offsetExists('PHPSESSID') && !empty($cookie->PHPSESSID)) {
            $params['session_id'] = $cookie->PHPSESSID;
        }

        Check::is_string($params['mail_to'], 'mail_to');
        Check::is_string($params['calculationparameter_id'], 'calculationparameter_id');
        Check::is_string($params['session_id'], 'session_id', true);

        $response = $this->get('Common\Provider\SendResultsPerEmail')->fetch($params);

        /** return json model */
        return $this->getJsonModel($response);

    }

    /**
     * Send the needed info to our Core-API, in order to handle tha favorites
     *
     * @return JsonModel
     */
    public function getHandleFavoriteAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();

        unset($params['controller']);
        unset($params['action']);

        Check::is_string($params['favorite_action'], 'favorite_action');

        if ($params['favorite_action'] == 'add_favorite') {
            return $this->addFavoriteAction();
        }

        if ($params['favorite_action'] == 'delete_favorite') {
            return $this->deleteFavoriteAction($params);
        }

        Check::is_integer($params['id'], 'id');

        $response = $this->get('Common\Provider\HandleFavorite')->fetch($params);

        /** return json model */
        return $this->getJsonModel($response);

    }

    /**
     * API-Request to add a favorite record in the DB
     *
     * @return JsonModel
     */
    public function addFavoriteAction() {

        $params = $this->params()->fromPost();

        $params['pkvfavorites_token'] = $this->getPkvfavoritesCookieValue();

        $response = $this->get('Common\Provider\HandleFavorite')->fetch($params);

        /** return json model */
        return $this->getJsonModel($response);

    }

    /**
     * API-Request to delete a favorite record from DB,
     * identified by the combination pkvfavorites && tariffversion_id
     *
     * @array $params       Request parameters
     * @return JsonModel
     */
    public function deleteFavoriteAction($params) {

        // better readability
        $params['tariffversion_id'] = $params['id'];
        unset($params['id']);

        Check::is_integer($params['tariffversion_id'], 'tariffversion_id', true);

        $params['pkvfavorites_token'] = $this->getPkvfavoritesCookieValue();

        $response = $this->get('Common\Provider\HandleFavorite')->fetch($params);

        /** return json model */
        return $this->getJsonModel($response);

    }

    /**
     * Send the needed info to our Core-API, in order to become the count of
     * favorites tariffs for a specific calculationparameter_id or for the
     * potential last calculationparameter_id
     *
     * @return JsonModel
     */
    public function getCountFavoriteAction() {

        $params = $this->getEvent()->getRouteMatch()->getParams();

        $params['pkvfavorites_token'] = $this->getPkvfavoritesCookieValue();

        unset($params['controller']);
        unset($params['action']);

        $response = $this->get('Common\Provider\CountFavorite')->fetch($params);

        /** return json model */
        return $this->getJsonModel($response);

    }

}