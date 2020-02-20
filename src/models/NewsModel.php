<?php

/**
 * Class NewsModel
 *
 * @package Models
 * @author Yukal Alexander <yukal@email.ua>
 * @copyright 2018 Yukal Alexander
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

namespace ssf\models;

use \ssf\engine\db;

class NewsModel
{
    // private $sth;
    private $structure = [
        // 'id'          => \PDO::PARAM_INT,
        'nofollow'    => \PDO::PARAM_BOOL,
        'noindex'     => \PDO::PARAM_BOOL,
        'title'       => \PDO::PARAM_STR,
        'description' => \PDO::PARAM_STR,
        'content'     => \PDO::PARAM_STR,
        'image'       => \PDO::PARAM_STR,
        'author'      => \PDO::PARAM_STR,
        'tags'        => \PDO::PARAM_STR,
        'date'        => \PDO::PARAM_STR,
        'district'    => \PDO::PARAM_INT,
        'rubric'      => \PDO::PARAM_INT,
    ];

    /**
     * Get one or more records from Database
     *
     * @param integer $id Primary key
     * @return array Rows/Row Data from Database
     */
    public function get($id = 0)
    {
        return $id > 0
            ? $this->getByPk($id)
            : $this->getAll();
    }

    /**
     * Get few records from Database
     * @return array Rows
     */
    public function getAll()
    {
        $dbh = new db();

        $fields = 'id,title,description,author,district,rubric,date';
        $query  = "SELECT {$fields} FROM `news` LIMIT 0,10";
        $sth = $dbh->prepare($query);

        if (!$sth->execute())
            $dbh->checkErrors($sth);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get record from Database by primary key
     *
     * @param integer $id
     * @return array Row
     */
    public function getByPk(int $id)
    {
        $dbh = new db();

        $query  = "SELECT * FROM `news` WHERE news.id=:id";
        $sth = $dbh->prepare($query);
        $sth->bindParam(":id", $id, \PDO::PARAM_INT);

        if (!$sth->execute())
            $dbh->checkErrors($sth);

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Add new record to a Database
     *
     * @param array $data
     * @return mixed Returns PDOStatement or Last inserted Id
     */
    public function add(array $data)
    {
        $dbh = new db();

        $columns = $this->buildParams($data, '`%key`');
        $values  = $this->buildParams($data, ':%key');

        $query  = "INSERT INTO `news` ({$columns}) VALUES ({$values})";
        $sth = $dbh->prepare($query);
        $this->bindParams($sth, $data);

        if (!$sth->execute())
            return $sth;
        // $dbh->checkErrors($sth);

        return $dbh->lastInsertId();
    }

    /**
     * Update one record in Database
     *
     * @param integer $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $dbh = new db();

        $values = $this->buildParams($data, '%key=:%key');

        if (empty($values))
            return false;

        $query  = "UPDATE `news` SET {$values} WHERE news.id=:id";
        $sth = $dbh->prepare($query);
        $this->bindParams($sth, $data);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Delete one record from Database
     *
     * @param integer $id Primary key
     * @return bool
     */
    public function delete(int $id)
    {
        $dbh = new db();

        $query  = sprintf("DELETE FROM news WHERE id=%d", $id);
        return $dbh->exec($query) > 0;
    }


    /**
     * PRIVATE
     * Bind parameters from array
     *
     * @param pointer $sth Pointer to PDO State handle
     * @param pointer $data Pointer to an array
     */
    private function bindParams(&$sth, &$data)
    {
        foreach ($data as $key => &$val) {
            if (array_key_exists($key, $this->structure)) {
                if ($key == 'date')
                    $val = date('Y-m-d', strtotime($val));

                $sth->bindParam(":$key", $val, $this->structure[$key]);
            }
        }
    }

    /**
     * PRIVATE
     * Build SQL params using specific data
     *
     * @param pointer $data Handle to an array
     */
    private function buildParams(&$data, $mask = "%key=:%key")
    {
        $values = [];
        foreach ($data as $key => &$val) {
            if (array_key_exists($key, $this->structure)) {
                $template = str_replace(['%key', '%val'], [$key, $val], $mask);
                array_push($values, $template);
                // array_push($values, "$key=:$key");
            }
        }

        return count($values) ? implode(',', $values) : false;
    }
}
