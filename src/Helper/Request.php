<?php
/**
 * Created by PhpStorm.
 * User: yves
 * Date: 30/09/17
 * Time: 11:05
 */

namespace deezer\Helper;


class Request
{


    /**
     * @param $var
     * @param string $type
     * @return mixed
     */
    public static function sanatizeItem($var, $type="string")
    {
        $flags = NULL;
        switch($type)
        {
            case 'url':
                $filter = FILTER_SANITIZE_URL;
                break;
            case 'int':
                $filter = FILTER_SANITIZE_NUMBER_INT;
                break;
            case 'float':
            case 'double':
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
                break;
            case 'email':
                $var = substr($var, 0, 254);
                $filter = FILTER_SANITIZE_EMAIL;
                break;
            case 'string':
            default:
                $filter = FILTER_SANITIZE_STRING;
                $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
                break;

        }

        return filter_var($var, $filter, $flags);

    }

    
    
    /**
     * @param $var
     * @param $type
     * @return bool
     */
    public static function validateItem($var, $type)
    {

        $filter = false;
        switch($type)
        {
            case 'email':
                $var = substr($var, 0, 254);
                $filter = FILTER_VALIDATE_EMAIL;
                break;
            case 'int':
                $filter = FILTER_VALIDATE_INT;
                break;
            case 'boolean':
                $filter = FILTER_VALIDATE_BOOLEAN;
                break;
            case 'ip':
                $filter = FILTER_VALIDATE_IP;
                break;
            case 'url':
                $filter = FILTER_VALIDATE_URL;
                break;
        }
        return ($filter === false) ? false : filter_var($var, $filter) !== false ? true : false;
    }


    /**
     * @param $varName
     * @param string $type
     * @return mixed|null|string
     */
    public static function getVar($varName, $type='string'){
        
        $inputData  = $_SESSION['input'];

        if(!is_array($inputData) || $inputData == '' || is_null($inputData)){
            return NULL;
        }

        if(!isset($inputData[$varName]) || $inputData[$varName] == '' || is_null($inputData[$varName])){
            return '';
        }
        $value  = $inputData[$varName];

        return Request::sanatizeItem($value,$type);

    }

    /**
     * @param $varName
     * @return mixed|null|string
     */
    public static function getInt($varName){
        return Request::getVar($varName,'int');
    }

    /**
     * @param $varName
     * @return mixed|null|string
     */
    public static function getString($varName){
        return Request::getVar($varName);
    }

    /**
     * @param $varName
     * @return mixed|null|string
     */
    public static function getEmail($varName){
        return Request::getVar($varName, 'email');
    }
    
    /**
     * @param array $data
     * @param null $message
     * @param int $code
     * @return string
     */
    public static function  jsonResponse($data=array(), $message = null, $code = 200)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($code);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');

        $status = array(
            200 => '200 OK',
            201 => '201 Created',
            204 => '204 No Content',
            400 => '400 Bad Request',
            403 => '403 Forbidden',
            404 => '404 Not Found',
            405 => '405 method Not Allowed',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        // ok, validation error, or failure
        header('Status: '.$status[$code]);

        // return the encoded json
        return json_encode(array(
            'status' => $code < 300, // success or not?
            'message' => $message,
            'data' => $data
        ));
    }

}