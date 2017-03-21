<?php

namespace Common\Api\Debug;

use ReflectionClass;
use shared\classes\common\rs_rest_client\rs_rest_client_request;

/**
 *  Generates Postmandumps for Requests to the API
 *
 *  @package Common\Api\Debug
 *  @author Alexander Roddis <alexander.roddis@check24.de>
 */
class Dumper
{
    /**
     * @var null
     */
    protected static $reflection_class = null;

    /**
     * @var array
     */
    protected static $collected_requests = [];

    /**
     * @var bool
     */
    protected static $is_inited = false;

    /**
     * @var string
     */
    protected static $file_path = null;

    /**
     * @var null
     */
    protected static $cwd = null;

    /**
     * @var string
     */
    protected static $collection_template = '{
        "id": "1342591b-b0e6-ff57-b20c-0f67f93e10e0",
        "name": "<<!collectionName!>>",
        "description": "",
        "order": [
            "8c9ed0f8-c13f-7c8f-d49c-254c09265c97"
        ],
        "folders": [],
        "timestamp": 0,
        "owner": "138227",
        "remoteLink": null,
        "public": false,
        "requests": <<!requests!>>
    }';

    /**
     * @var string
     */
    protected static $requests_template = '{
        "headers": "<<!headers!>>",
        "url": "<<!url!>>",
        "pathVariables": {},
        "preRequestScript": "",
        "method": "<<!method!>>",
        "data": <<!data!>>,
        "dataMode": "raw",
        "currentHelper": "basicAuth",
        "helperAttributes": {
            "username": "{{api-user}}",
            "password": "{{api-pass}}",
            "saveToRequest": true,
            "id": "basic",
            "timestamp": 1441032921127
        },
        "name": "<<!name!>>",
        "description": "",
        "descriptionFormat": "html",
        "tests": "var data = JSON.parse(responseBody);\ntests[\"Response has correct status code\"] = data.status_code === 200;\ntests[\"Response has correct status msg\"] = data.status_message === \"OK\";",
        "rawModeData": "",
        "id": "<<!id!>>",
        "collectionId": "1342591b-b0e6-ff57-b20c-0f67f93e10e0"
    }';

    /**
     * @param rs_rest_client_request $request
     *
     * @return void
     */
    public static function add_request(rs_rest_client_request $request)
    {
        if (!self::$is_inited) {
            self::init();
        }

        self::$collected_requests[] = $request;
    }

    /**
     *
     * @return void
     */
    public static function dump()
    {
        if (null === self::$file_path) {
            self::$file_path = self::$cwd . "/logs/common/postman";
        }

        self::normalize_file_path();

        if (!file_exists(self::$file_path)) {
            mkdir(self::$file_path, 0777, true);
        }


        file_put_contents(self::$file_path . self::get_filename($_SERVER["REQUEST_URI"]), self::generate_json());
    }

    /**
     * @param $file_path
     *
     * @return void
     */
    public function set_file_path($file_path)
    {
        self::$file_path = $file_path;
    }

    /**
     *
     * @return void
     */
    protected static function init()
    {
        register_shutdown_function(array('Common\\Api\\Debug\\Dumper', 'dump'));

        self::$cwd = getcwd();
        self::$is_inited = true;
    }

    /**
     *
     * @return string
     */
    protected static function generate_request_json()
    {

        $request_json = [];

        foreach (self::$collected_requests as $request) {
            $parameter = self::get_parameter($request);

            $method = self::get_method($request);

            $url = "http://{{host}}" . self::get_url($request);

            if ($method === "POST") {
                $request_json[] = self::render_template(self::$requests_template, array(
                    "data" => json_encode($parameter),
                    "method" => $method,
                    "url" => $url,
                    "headers" => "",
                    "name" => self::get_property($request, "module"),
                    "id" => uniqid("request-")
                ));
            } elseif ($method === "GET") {
                $request_json[] = self::render_template(self::$requests_template, array(
                    "data" => "[]",
                    "method" => $method,
                    "url" => (count($parameter) > 0) ? "$url?" . \GuzzleHttp\Psr7\build_query($parameter) : $url,
                    "headers" => "",
                    "name" => self::get_property($request, "module"),
                    "id" => uniqid("request-")
                ));
            }
        }

        return "[" . implode(",", $request_json) . "]";
    }

    /**
     *
     * @return mixed
     */
    protected static function generate_json()
    {
        $requestJson = self::generate_request_json();

        $collectionJson = self::render_template(self::$collection_template, array(
            "collectionId" => uniqid("collectionId"),
            "collectionName" => self::get_identifier($_SERVER["REQUEST_URI"]),
            "requests" => $requestJson
        ));

        return $collectionJson;
    }

    /**
     * @param $templateString
     * @param $params
     *
     * @return mixed
     */
    protected static function render_template($templateString, $params)
    {
        foreach ($params as $paramName => $paramValue) {
            $templateString = str_replace("<<!$paramName!>>", $paramValue, $templateString);
        }

        return $templateString;
    }

    /**
     * @param rs_rest_client_request $request
     *
     * @return mixed
     */
    protected static function get_parameter(rs_rest_client_request $request)
    {
        return self::get_property($request, "parameters");
    }

    /**
     * @param rs_rest_client_request $request
     *
     * @return mixed
     */
    protected static function get_method(rs_rest_client_request $request)
    {
        $method = self::get_reflection_class($request)->getMethod("get_method");

        $method->setAccessible(true);

        return $method->invoke($request);
    }

    /**
     * @param rs_rest_client_request $request
     * @param                        $propertyName
     *
     * @return mixed
     */
    protected static function get_property(rs_rest_client_request $request, $propertyName)
    {
        $property = self::get_reflection_class($request)->getProperty($propertyName);

        $property->setAccessible(true);

        return $property->getValue($request);
    }

    /**
     * @param rs_rest_client_request $request
     *
     * @return string
     */
    protected static function get_url(rs_rest_client_request $request)
    {
        $module = self::get_property($request, "module");

        return '/app/api/' . $module . '/';
    }

    /**
     * @param rs_rest_client_request $request
     *
     * @return null|ReflectionClass
     */
    protected static function get_reflection_class(rs_rest_client_request $request)
    {
        if (self::$reflection_class === null) {
            self::$reflection_class = new ReflectionClass($request);
        }

        return self::$reflection_class;
    }

    /**
     *
     * @return string
     */
    protected static function get_filename($request_uri)
    {
        $name = self::get_identifier($request_uri);

        return "$name.collection.json";
    }

    protected static function get_identifier($request_uri)
    {
        $request_uri = preg_replace("#\\?.*#", "", $request_uri);

        $request_uri = preg_replace("#^\\/#", "", $request_uri);

        $request_uri = preg_replace("#\\/$#", "", $request_uri);

        return preg_replace("#(?<!^)\\/(?!$)#", "_", $request_uri);
    }

    protected static function normalize_file_path()
    {
        if (!preg_match('#.*\/$#', self::$file_path)) {
            self::$file_path .= "/";
        }
    }


}