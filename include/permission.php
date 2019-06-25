<?php
require_once "constant.php";
include "include/database.php";
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
        $sql = "SELECT * FROM user 
                INNER JOIN rolesRights AS rr ON rr.rolesFID = user.rolesFID
                WHERE userID = $userID;";
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

