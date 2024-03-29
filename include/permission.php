<?php
require_once "constant.php";
require_once "include/database.php";
/**
 * class Permissson handles all permission related methods
 * @author Christian Rieger
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
            #var_dump($result);
        }
        return $ret;
    }

    public function hasPermission($permission):bool {
        if(empty($_SESSION) || !isset($_SESSION[USER_PERMISSION])){
            return FALSE;
        }
        $ret = FALSE;
        $perms = $_SESSION[USER_PERMISSION];
        foreach ($perms as $key=>$item) {
            if($item['name'] == $permission){
                $ret = TRUE;
                break;
            }
        }
        return $ret;
    }

}

