<?php 
#constant.php
#first draft
#requires variable $checkme
if(isset($GLOBALS['checkme']) && $GLOBALS['checkme'] !== "a30ee472364c50735ad1d43cc09be0a1"){
    exit();
}

#page settings
const PAGE_NAME = "AMS";
const PAGE_ICON = "img/ams.svg";
const PAGE_DESC = "Beschaffungsportal für das AMS Wien";

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
const DB_HOST = "192.168.1.84";
const DB_NAME = "vemap02";
CONST DB_CHARSET = "utf8";
const DB_USER = "vemap";
const DB_PWD = "vemap1234!";
