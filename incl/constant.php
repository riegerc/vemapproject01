<?php 
#constant.php
#first draft
#requires variable $checkme
if($GLOBALS['checkme'] !== "a30ee472364c50735ad1d43cc09be0a1"){
    exit();
}
#$_SESSION BLOCK
const USER_ROLE = "userRole";
const USER_ID = "userID";
const USER_NAME = "userName";


#pwd validation
const MIN_PWD_LEN = 2;
const MAX_PWD_LEN = 50;
const PWD_REQ_UPPER_CASE = 0;
const PWD_REQ_LOWER_CASE = 0;
const PWD_REQ_SPECIAL_CHAR = 0;


#permissions example
const PERM_CED_USER = "cedUser";
const PERM_VIEW_USER = "viewUser";


#db data
const DB_HOST = "remotemysql.com";
const DB_NAME = "e5En6pGWNA";
CONST DB_CHARSET = "utf8";
const DB_USER = "e5En6pGWNA";
const DB_PWD = "gwWmxvxZbZ";