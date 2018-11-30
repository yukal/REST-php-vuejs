<?php

namespace ssf\engine;

/**
 * Class db
 * 
 * @package Engine
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

use PDO;

class db extends PDO {
    /**
     * Constructor
     *
     * @param string $dbuser
     * @param string $dbpass
     * @param string $dbname
     * @param string $dbhost
     * @param integer $dbport
     */
    public function __construct($dbuser='user', $dbpass='pass', $dbname='db', $dbhost='mariadb', $dbport=3306) {
        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        parent::__construct($dsn, $dbuser, $dbpass, $params);
    }

    /**
     * checkErrors
     *
     * @param resource $sth PDO State Handle
     * @return bool
     */
    public function checkErrors(&$sth) {
        if ($sth->errorCode() === '00000')
            return true;

        $response = [
            'Error Code' => $sth->errorCode(),
            'Error Info' => $sth->errorInfo(),
        ];

        echo json_encode($response);
        exit;
    }

}
