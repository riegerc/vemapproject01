<?php
require_once "validate.php";

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

/**
 * important: the SQL Statement in the $sql variable MUST start with select (case insensitive)!
 * please use $param array if the statement contains user imput. This goes like this:
 * $sql = "SELECT * FROM tablename WHERE column1 = :placeholder1 and column2 = :placeholder2;";
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * 
 */
function readDB(string $sql, array $params = NULL){
    $result = [];
    if(!isSqlSelect($sql)){return "No SELECT SQL Statement!";}

    $db = connectDB();
    
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($param);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $ex){
        die("DB - Error SELECT");
        return $result;
    }

    return $result;
}

/**
 * important the SQL statement MUST start with INSERT (case insensitive)!
 * the param array is to use like in the readDB (only  with an INSERT INTO Statement):
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 */
function writeDB(string $sql, array $params):int{
    $ret = 0;
    if(!isSqlInsert($sql)){return -1;}

    $db = connectDB();

    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($param);
        $ret = $db->lastInsertId();
    }catch(Exception $ex){
        die("DB - Error INSERT");
        return -1;
    }
    return $ret;
}
