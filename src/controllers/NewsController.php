<?php

namespace ssf\controllers;

/**
 * Class NewsController
 * 
 * @package Controllers
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

use \ssf\engine\RestException;
use \ssf\models\NewsModel;

class NewsController {

    /**
     * actionGet (Read)
     * @param int $id Id key of the record
     * @throws RestException 404 Not Found;
     * @return array Rows
     */
    public function actionGet($id=0) {
        $model = new NewsModel();
        $data = $model->get($id);

        if ($data === false)
            throw new RestException(404);

        return $data;
    }

    /**
     * actionPut (Create)
     * @param int $id Id key of the record (Required)
     * @throws RestException 404 Not Found;
     * @return array Data of the last inserted Id
     */
    public function actionPut(array $data) {
        $model = new NewsModel();
        $res = $model->add($data);

        if ($res instanceof \PDOStatement) {
            $errorInfo = $res->errorInfo();

            $response = ['error'=>[
                'code' => $errorInfo[0],
                'message' => $errorInfo[2],
            ]];

            throw new RestException(404, json_encode($response));
        }

        return ['id' => $res];
    }

    /**
     * actionPatch (Update)
     * @param int $id Id key of the record (Required)
     * @throws RestException 404 Not Found;
     * @return bool
     */
    public function actionPatch(int $id, array $data) {
        $model = new NewsModel();
        $res = $model->update($id, $data);

        if ($res instanceof \PDOStatement) {
            $errorInfo = $res->errorInfo();

            $response = ['error'=>[
                'code' => $errorInfo[0],
                'message' => $errorInfo[2],
            ]];

            throw new RestException(404, json_encode($response));
        }

        return $res;
    }

    /**
     * actionDelete (Delete)
     * @param int $id Id key of the record (Required)
     * @throws RestException 404 Not Found;
     * @return bool
     */
    public function actionDelete(int $id) {
        $model = new NewsModel();
        $res = $model->delete($id);

        if ($res === false)
            throw new RestException(404);

        return $res;
    }

}