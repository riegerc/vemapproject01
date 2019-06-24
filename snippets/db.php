<?php
$dbHost = "remotemysql.com";
$dbName = "e5En6pGWNA";
$dbCharset = "utf8";
$dbUser = "e5En6pGWNA";
$dbPw = "gwWmxvxZbZ";

try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName;dbcharset=$dbCharset;", "$dbUser", "$dbPw");
    //echo "Database Connected Successfully <br><br>";
} catch (PDOException $e) {
    die("That didn't work");
}
