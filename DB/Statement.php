<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 18:14
 */

namespace deezer\DB;


class Statement extends \PDOStatement
{
    public function fetchField($fieldname = 0) {
        $data = $this->fetch(\PDO::FETCH_BOTH);
        if (!isset($data[$fieldname])) {
            $data[$fieldname] = FALSE;
        }
        return $data[$fieldname];
    }
}