<?php
    // to connect with database 
    $dsn = 'mysql:hostname=localhost;dbname=shop';
    $username = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    try
    {
        $connect = new PDO($dsn,$username,$pass,$option);
        $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    catch(PDOException $e)
    {
        echo 'field to connect' . $e->getMessage();
    }