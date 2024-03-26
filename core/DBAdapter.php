<?php

class DBAdapter
{
    static public function getConnection()
    {
        $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE_NAME);
        if (!$connect) die('Mysql connection error: ' . mysqli_error($connect));
        return $connect;
    }
}
