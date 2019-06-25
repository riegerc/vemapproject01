<?php

function connectDB(): PDO
{
    $dbHost = "remotemysql.com";
    $dbName = "e5En6pGWNA";
    $dbCharset = "utf8";
    $dbUser = "e5En6pGWNA";
    $dbPw = "gwWmxvxZbZ";

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
