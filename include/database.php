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
            "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset;", //replacing dbcharset with just charset to see if it fixed the utf8 issue. will change back soon if fail
            "$dbUser",
            "$dbPw",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die("That didn't work.<br><br>$e");
    }
}

/**
 * @deprecated do not use if not familar with it!
 * important: the SQL Statement in the $sql variable MUST start with select (case insensitive)!
 * please use $param array if the statement contains user imput. This goes like this:
 * $sql = "SELECT * FROM tablename WHERE column1 = :placeholder1 and column2 = :placeholder2;";
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array|null $params
 * @return array|string if returns array, it looks like: array[ array[row[columname1,columnname2,columnname3],
 *                                                                    row[columname1,columnname2,columnname3],
 *                                                                    row[columname1,columnname2,columnname3]]]
 * @author ch. rieger
 */
function readDB(string $sql, array $params = NULL, $fetchMode = PDO::FETCH_ASSOC)
{
    $result = [];

    if (!isSqlSelect($sql)) {
        return "No SELECT SQL Statement!";
    }

    $db = connectDB();

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll($fetchMode);
    } catch (Exception $ex) {
        die("DB - Error SELECT");
    }

    return $result;
}

/**
 * @deprecated do not use if not familar with it!
 * important the SQL statement MUST start with INSERT (case insensitive)!
 * the param array is to use like in the readDB (only  with an INSERT INTO Statement):
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array $params
 * @return int index (objectID) of last inserted row
 * @author ch. rieger
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
 * @deprecated do not use if not familar with it!
 * important the SQL statement MUST start with UPDATE (case insensitive)!
 * the param array is to use like in the readDB (only  with an UPDATE Statement):
 * $param = array(":placeholder1"=>$variable1,":placeholder2"=>$variable2); This replaces the bindParam()
 * @param string $sql
 * @param array $params
 * @return bool
 * @author ch. rieger
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