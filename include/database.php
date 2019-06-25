<?php

function connectDB(): PDO
{
    $dbHost = DB_HOST;
    $dbName = DB_NAME;
    $dbCharset = DB_CHARSET;
    $dbUser = DB_USER;
    $dbPw = DB_PWD;

    try {
        return new PDO(
            "mysql:host=$dbHost;dbname=$dbName;dbcharset=$dbCharset;",
            "$dbUser",
            "$dbPw",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die("That didn't work");
    }
}
