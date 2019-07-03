<?php
/**constant.php
 * @author Christian Rieger
 */
#requires variable $checkme
if ($GLOBALS['checkme'] !== "a30ee472364c50735ad1d43cc09be0a1") {
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
const PERM_EDIT_PERM = "editPermission"; //external admin only, this permission grants permission to edit PERMISSIONS (rolerights.php)
const PERM_VIEW_OFFER_MENU = "viewOfferMenu"; // user can see the whole of "Ausschreibungen" category (nav)
const PERM_VIEW_RATING_MENU = "viewRatingMenu"; // user can see the whole of "Bewertungen" category(nav)
const PERM_VIEW_WEBSHOP_MENU  = "viewWebShopMenu"; // user can see the whole of "Webshop" category(nav)
const PERM_VIEW_CLIENT_MENU = "viewClientMenu"; // user can see the whole of "User" category (nav)
const PERM_CED_SUPPLIER = "cedSupplier"; // user can CREATE new supplies(lieferanten), Ausschreibungen->Lieferant anlegen
const PERM_VIEW_OFFER = "viewOffer"; // user can see Ausschreibungen->"Ihre Ausschreibungen"
const PERM_ORDER_FROM_CATALOGUE = "orderFromCataloge"; //user has access to the Webshop->kunde catalogue
const PERM_INSERT_INTO_CATALOGUE = "insertIntoCataloge"; //user( Only external admin) can accept orders
const PERM_VIEW_REVIEW = "viewReview"; //user(mainly SUPPLIER) can see their own RATING(review,feedback,Bewertung)
const PERM_MAKE_REVIEW = "makeReview"; //user can GIVE RATINGS
const PERM_CED_REVIEW = "cedReview"; //internal/external Admin may edit the rating FORM itself under Bewertungen->kriterien
const PERM_CED_USER = "cedUser"; //internal/external Admin can CREATE users under User->Erstellen
const PERM_EDIT_SELF = "editUser"; //everyone can edit THEIR OWN DETAILS
const PERM_VIEW_PERMISSIONS = "viewPermissions"; #the right to view rightRoles.php

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


#add select all/none links on rightroles.php
const SHOW_SELECT_ALL_LINKS = 0;

#db data
//const DB_HOST = "192.168.1.84";
//const DB_NAME = "vemap02";
//CONST DB_CHARSET = "utf8";
//const DB_USER = "vemap";
//const DB_PWD = "vemap1234!";

//# new db data
const DB_HOST = "remotemysql.com";
const DB_NAME = "XlYChOI4BN";
const DB_CHARSET = "utf8";
const DB_USER = "XlYChOI4BN";
const DB_PWD = "e8qAM7qkK6";