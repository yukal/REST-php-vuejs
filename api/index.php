<?php

/**
 * API entry point
 * 
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

// Register Autoloader
require '..'
    . DIRECTORY_SEPARATOR . 'vendor' 
    . DIRECTORY_SEPARATOR . 'autoload.php';

use \ssf\controllers;
use \ssf\engine\RestException;
use \ssf\engine\Request;

// TODO: Authorization by API key
$apiKey = 'QH4iM3l+K0xQWipVQXkha242RD5hbiFlJUomO31HV0d0dHd9e01OUSpDSl5TNCJ4bS1UdnhgeT9tfHMiMkVL';
$requestKey = array_key_exists('HTTP_AUTHORIZATION', $_SERVER)
    ?$_SERVER['HTTP_AUTHORIZATION'] :'';
// $code = base64_decode($requestKey);
// if ($apiKey !== $requestKey) {
//     header('401 Unauthorized', 1, 401);
//     exit;
// }

$contentType = array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)
    ? $_SERVER['HTTP_CONTENT_TYPE'] : $_SERVER['CONTENT_TYPE'];

$requestMethod = array_key_exists('HTTP_X_REST_METHOD', $_SERVER)
    ? strtolower($_SERVER['HTTP_X_REST_METHOD'])
    : strtolower($_SERVER['REQUEST_METHOD']);

$requestData = file_get_contents('php://input');
if (false !== strpos($contentType, 'application/json'))
    $args = json_decode($requestData, true);
else
    parse_str($requestData, $args);

// Remove slash '/' at the 1-st position of the URI
$requestUri = substr($_SERVER['REQUEST_URI'], 1);
$requestUri = strtolower($requestUri);

$chunksUri = explode('/', $requestUri, 6);
$controllerName = empty($requestUri) ?'default' :array_shift($chunksUri);
$controllerName = ucfirst($controllerName).'Controller';
$controllerAction = 'action'.ucfirst($requestMethod);

// Controller Namespace
$controllerNS = "ssf\\controllers\\{$controllerName}";

if (in_array($requestMethod, ['get','delete'])) {
    $args = count($chunksUri) ?$chunksUri :[];
}

if (in_array($requestMethod, ['put','patch'])) {
    $id = array_shift($chunksUri);
    $args = ['id'=>$id] + $args;
}
// $argc = count($args);

// Checks if the method exists in the controller using encapsulation.
// It would available if the method declared as public. 
// Otherwise, it throws an error
if (! is_callable([$controllerNS, $controllerAction]))
    throw new RestException(404, "Wrong Request-Uri: ".$_SERVER['REQUEST_URI']);

$res = call_user_func_array([new $controllerNS(), $controllerAction], $args);
echo json_encode($res);