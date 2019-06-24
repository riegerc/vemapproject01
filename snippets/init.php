<?php
include "settings.php";
include "db.php";
session_start();
session_regenerate_id(true);
$loggedIn = false;

function setTitle($title)
{
    echo "<title>$title | Top News</title>";
}

function setMeta($name, $content)
{
    echo "<meta name='$name' content='$content'/>";
}

if ($pageRestricted === true) {
    if (empty($_SESSION)) {
        header("location:logout.php");
    }

    if ($userLevel > $_SESSION["userRole"]) {
        header("location:error.php?e=403");
    }
}

if (isset($_POST["login"])) {
    $email = htmlspecialchars($_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $sql = "SELECT * FROM user WHERE userEmail=:email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();
        $loggedIn = true;

        if ($row) {
            if (password_verify($_POST["password"], $row["userPassword"])) {
                $_SESSION["userID"] = $row["userID"];
                $_SESSION["userName"] = $row["userName"];
                $_SESSION["userRole"] = $row["userRole"];
                header("location:index.php");
            } else {
                $error = "Die Email/Passwort Kombination stimmt nicht.";
            }
        }
    } else {
        $error = "Die Email/Passwort Kombination stimmt nicht.";
    }
}