<?php 
#constant.php
#first draft
#requires variable $checkme
if($GLOBALS['checkme'] !== "a30ee472364c50735ad1d43cc09be0a1"){
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
const USER_PERMISSION = "userPermission";


#pwd validation
const MIN_PWD_LEN = 2;
const MAX_PWD_LEN = 50;
const PWD_REQ_UPPER_CASE = 0;
const PWD_REQ_LOWER_CASE = 0;
const PWD_REQ_SPECIAL_CHAR = 0;

#permissions example
const PERM_CED_USER = "cedUser"; # NOT including SELF!
const PERM_EDIT_SELF = "editSelf"; #useless, because everyone can edit him/herself, but noone can delete him/herself
const PERM_VIEW_USER = "viewUser"; # NOT including SELF!
const PERM_EDIT_BUDGED = "editBudtget"; # can not apply to SELF
const PERM_CED_OFFER = "cedOffer";
const PERM_VIEW_OFFER = "viewOffer";
const PERM_CED_CATALOGE = "cedCataloge";
const PERM_VIEW_CATALOGE = "viewCataloge";
const PERM_ORDER_FROM_CATALOGE = "orderFromCataloge";
const PERM_INSERT_INTO_CATALOGE = "insertIntoCataloge";
const PERM_SHOP_CATALOGE = "shopCataloge";
const PERM_SHOP_ARTICLE = "shopArticle";
const PERM_VIEW_CLIENT_MENU = "viewClientMenu";
const PERM_VIEW_SUPPLIER_MENU  = "viewSupplierMenu";
const PERM_EDIT_CLIENT_ADDRESS = "editClientAddress";
const PERM_RELEASE_CATALOG_ITEM = "releaseCalalogItem";
const PERM_CED_REVIEW = "cedReview";
const PERM_VIEW_REVIEW = "viewReview";
const PERM_MAKE_REVIEW = "makeReview";
const PERM_REVIEW_SUPPLIER = "reviewSupplier";
const PERM_REVIEW_ARTICLE = "reviewArticle";
const PERM_SUBMIT_OFFER = "submitOffer";

#db data
const DB_HOST = "remotemysql.com";
const DB_NAME = "XlYChOI4BN";
CONST DB_CHARSET = "utf8";
const DB_USER = "XlYChOI4BN";
const DB_PWD = "e8qAM7qkK6!";
