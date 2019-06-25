<?php
include "constant.php";
include "include/database.php";
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
        $sql = "SELECT * FROM login WHERE email=:email";
        $stmt = connectDB()->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();
        $loggedIn = true;

        if ($row) {
            if (password_verify($_POST["password"], $row["password"])) {
                $_SESSION["userID"] = $row["objectID"];
                $_SESSION["userName"] = $row["email"];
                $_SESSION["userRole"] = $row["amsLogin"];
                header("location:index.php");
            } else {
                $error = "Die Email/Passwort Kombination stimmt nicht.";
            }
        }
    } else {
        $error = "Die Email/Passwort Kombination stimmt nicht.";
    }
}

if (isset($_POST["logout"])) {
    session_start();
    session_destroy();
    header("location:index.php");
}
