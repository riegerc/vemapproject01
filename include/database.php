<?php
require_once "validate.php";

function connectDB(): PDO
{
    $dbHost = "https://remotemysql.com/phpmyadmin";
    $dbName = "XlYChOI4BN";
    $dbCharset = DB_CHARSET;
    $dbUser = "XlYChOI4BN";
    $dbPw = "e8qAM7qkK6";

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

/**
 * important: the SQL Statement in the $sql variable MUST start with select (case insensitive)!
 * please use $param array if the statement contains user imput. This goes like this:
 * $sql = "SELECT * FROM tablename WHERE column1 = :placeholder1 and column2 = :placeholder2;";
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array|null $params
 * @return array|string
 */
function readDB(string $sql, array $params = NULL)
{
    $result = [];

    if (!isSqlSelect($sql)) {
        return "No SELECT SQL Statement!";
    }

    $db = connectDB();

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        die("DB - Error SELECT");
    }

    return $result;
}

/**
 * important the SQL statement MUST start with INSERT (case insensitive)!
 * the param array is to use like in the readDB (only  with an INSERT INTO Statement):
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array $params
 * @return int
 */
function insertDB(string $sql, array $params): int
{
    $ret = 0;

    if (!isSqlInsert($sql)) {
        return -1;
    }

    $db = connectDB();

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $ret = $db->lastInsertId();
    } catch (Exception $ex) {
        die("DB - Error INSERT");
    }
    return $ret;
}

/**
 * important the SQL statement MUST start with UPDATE (case insensitive)!
 * the param array is to use like in the readDB (only  with an UPDATE Statement):
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array $params
 * @return bool
 */
function updateDB(string $sql, array $params): bool
{
    $ret = false;

    if (!isSqlSelect($sql)) {
        return false;
    }

    $db = connectDB();

    try {
        $stmt = $db->prepare($sql);
        $ret = $stmt->execute($params);
    } catch (Exception $ex) {
        die("DB - Error UPDATE");
    }
    return $ret;

}