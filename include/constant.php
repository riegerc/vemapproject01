<?php 
/**constant.php
 * @author Christian Rieger
 */
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

#permissions in use ------------------------------------------
const PERM_EDIT_PERM = "editPermission";
const PERM_VIEW_OFFER_MENU = "viewOfferMenu";
const PERM_VIEW_RATING_MENU = "viewRatingMenu";
const PERM_VIEW_WEBSHOP_MENU  = "viewWebShopMenu";
const PERM_VIEW_CLIENT_MENU = "viewClientMenu";
const PERM_CED_SUPPLIER = "cedSupplier";
const PERM_VIEW_OFFER = "viewOffer";
const PERM_ORDER_FROM_CATALOGUE = "orderFromCataloge";
const PERM_INSERT_INTO_CATALOGUE = "insertIntoCataloge";
const PERM_VIEW_REVIEW = "viewReview";
const PERM_MAKE_REVIEW = "makeReview";
const PERM_CED_REVIEW = "cedReview";
const PERM_CED_USER = "cedUser"; # NOT including SELF!
const PERM_EDIT_SELF = "editUser"; #everyone can edit him/herself, but noone can delete him/herself

#permissions not in use now----------------------------------
const PERM_VIEW_USER = "viewUser";
const PERM_EDIT_BUDGED = "editBudtget"; 
const PERM_CED_OFFER = "cedOffer";
const PERM_CED_CATALOGUE = "cedCatalogue";
const PERM_VIEW_CATALOGUE = "viewCatalogue";
const PERM_SHOP_CATALOGUE = "shopCatalogue";
const PERM_SHOP_ARTICLE = "shopArticle";
const PERM_EDIT_CLIENT_ADDRESS = "editClientAddress";
const PERM_RELEASE_CATALOG_ITEM = "releaseCalalogItem";
const PERM_REVIEW_SUPPLIER = "reviewSupplier";
const PERM_REVIEW_ARTICLE = "reviewArticle";
const PERM_SUBMIT_OFFER = "submitOffer";




#db data
//const DB_HOST = "192.168.1.84";
//const DB_NAME = "vemap02";
//CONST DB_CHARSET = "utf8";
//const DB_USER = "vemap";
//const DB_PWD = "vemap1234!";

//# new db data
const DB_HOST = "remotemysql.com";
const DB_NAME = "XlYChOI4BN";
CONST DB_CHARSET = "utf8";
const DB_USER = "XlYChOI4BN";
const DB_PWD = "e8qAM7qkK6";
