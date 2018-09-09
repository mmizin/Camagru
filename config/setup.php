<?php
include('database.php');

$servername = "127.0.0.1:3307";

    // try {
    //     $conn = new PDO("mysql:host=$servername", $DB_USER, $DB_PASSWORD);

    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //     $sql = "CREATE DATABASE IF NOT EXISTS ". $DB_NAME;
    //     $conn->exec($sql);

    // }
    // catch(PDOException $e)
    // {
    //     echo $sql . "<br>" . $e->getMessage();
    // }
    // $conn = null;

    try {

        $conn = new PDO('mysql:host=localhost;', $DB_USER, $DB_PASSWORD);
        $sql = "CREATE DATABASE IF NOT EXISTS ". $DB_NAME;
        $conn->exec($sql);

        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = file_get_contents("db_camagru.sql");
        $conn->exec($sql);
    }
    catch(PDOException $e)
    {

        echo "Something go wrong " . $e->getMessage();
    }


