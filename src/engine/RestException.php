<?php

namespace ssf\engine;

/**
 * Class RestException
 * 
 * @package Engine
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

use \Exception;

class RestException extends Exception {

    /**
     * Constructor
     *
     * @param integer $code
     * @param string $msg [optional]
     */
    public function __construct(int $code, $msg='') {
        parent::__construct($message, $code, $previous);

        $errorInfo = $this->getHttpCode($code);
        header("HTTP/1.1 {$code} {$errorInfo}", 1, $code);

        if (! empty($msg))
            echo json_encode(['error' => $msg]);
        exit;
    }

    /**
     * getHttpCode [:private]
     *
     * @param integer $code
     * @return string Message
     */
    private function getHttpCode(int $code) {
        $codes = [

            // 1xx: Informational

            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',

            // 2xx: Success:

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',

            // 3xx: Redirection:

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Moved Temporarily',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'reserved',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',

            // 4xx: Client Error:

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I’m a teapot',
            421 => 'Misdirected Request [10];',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            449 => 'Retry With',
            451 => 'Unavailable For Legal Reasons',

            // 5xx: Server Error

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            520 => 'Unknown Error',
            521 => 'Web Server Is Down',
            522 => 'Connection Timed Out',
            523 => 'Origin Is Unreachable',
            524 => 'A Timeout Occurred',
            525 => 'SSL Handshake Failed',
        ];

        if (!array_key_exists($code, $codes))
            $code = 418;

        return $codes[$code];
    }

}