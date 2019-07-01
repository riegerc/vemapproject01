<?php
// Author: Oliver Stingl

$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "constant.php";
require_once "include/database.php";
require_once "include/permission.php";
session_start();
session_regenerate_id(true);
$loggedIn = false;
$perm = new Permission();
function setTitle($title)
{
    echo "<title>$title | Top News</title>";
}

function setMeta($name, $content)
{
    echo "<meta name='$name' content='$content'/>";
}

if (isset($_POST["login"])) {
    $email = htmlspecialchars($_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $sql = "SELECT * FROM user WHERE email=:email";
        $stmt = connectDB()->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();
        $loggedIn = true;

        if ($row) {
            if (password_verify($_POST["password"], $row["password"])) {
                $_SESSION[USER_ID] = $row["objectID"];
                $_SESSION[USER_NAME] = $row["email"];
                $_SESSION[USER_ROLE] = $row["rolesFID"];
                #$perm = new Permission();
                if(!$perm->loadPermissions($_SESSION[USER_ID])){
                    $error = "Laden der Berechtigungen fehlgeschlagen.";
                }else{
                    header("location:index.php");
                }  
            } else {
                $error = "Die Email/Passwort Kombination stimmt nicht.";
            }
        }
    } else {
        $error = "Die Email/Passwort Kombination stimmt nicht.";
    }
}

if ($pageRestricted === true) {
    if (empty($_SESSION)) {
        header("location:logout.php");
    }
    
    if (!$perm->hasPermission($userLevel)) {
       header("location:error.php?e=403");
    }
}

if (isset($_POST["logout"])) {
    session_start();
    session_destroy();
    header("location:index.php");
}
