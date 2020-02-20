<?php

/**
 * Class DefaultController
 *
 * @package Controllers
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

namespace ssf\controllers;

class DefaultController
{

    /**
     * actionMain
     * @return string Method name
     */
    public function actionMain()
    {
        $response = [
            'action' => __METHOD__,
            'method' => $_SERVER['REQUEST_METHOD'],
            'args' => '',
        ];

        // echo json_encode($response);
        return $response;
    }

    public function actionGet()
    {
        return $this->actionMain();
        // $data = [__DIR__, __FILE__, __NAMESPACE__, __CLASS__, __METHOD__, __FUNCTION__, __LINE__];
        // printf("<pre>%s\n", implode("\n", $data));
        // echo static::class;
    }
}
