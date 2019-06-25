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
 * 
 */
function readDB(string $sql, array $paramy = NULL){
    $result = [];
    if(!isSqlSelect($ql)){return "Kein SELECT SQL Statement!";}

    $db = connectDB();
    
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($param);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $ex){
        die("DB - Error");
        return $result;
    }
    return $result;
}
