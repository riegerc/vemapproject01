<?php
require_once "constant.php";
require_once "include/database.php";
/**
 * class Permissson handels all permission releated methods
 */
class Permission {

    public function __construct(){

    }

    public function loadPermissions($userID):bool {
        if(empty($_SESSION) || !isset($_SESSION[USER_ID])){
            return FALSE;
        }
        $ret = TRUE;
        $sql = "SELECT r.name FROM user AS u
                INNER JOIN rolesrights AS rr ON rr.rolesFID = u.rolesFID
                INNER JOIN rights AS r ON r.objectID = rr.rightsFID
                WHERE u.objectID = $userID;";
        $result = readDB($sql);
        if(count($result) == 0){
            $ret = FALSE;
        }else{
            $_SESSION[USER_PERMISSION] = $result;
        }
        return $ret;
    }

    public function hasPermission($permission):bool {
        if(empty($_SESSION) || !isset($_SESSION[USER_PERMISSION])){
            return FALSE;
        }
        $ret = FALSE;
        $perms = $_SESSION[USER_PERMISSION];
        foreach ($perms as $item) {
            if(isset($item[$permission])){
                $ret = TRUE;
                break;
            }
        }
        return $ret;
    }

}

