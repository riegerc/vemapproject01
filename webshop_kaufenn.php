<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Webshop kaufen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

if(isset($_GET['update'])){
            $objectID=(int)$_GET['update'];
}elseif(isset($_POST['update'])){
    $objectID=(int)$_POST['objectID'];
}else{
    exit("Kein object gewaehlt");
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Kurs</title>
</head>
<body>
<div class="container-fluid">
<form action="artikel_kaufen.php" method="post">
    <?php

    if(isset($_POST['update'])){
        $name=$_POST['name'];
        $price=$_POST['price'];
        $description=$_POST['description'];
    }

    $sql="SELECT * FROM article WHERE objectID=:objectID";
    $stmt=connectDB()->prepare($sql);
    $stmt->bindParam(":objectID",$objectID);
    $stmt->execute();

    $row=$stmt->fetch();
    echo "<h3>Artikel Bestellen:</h3><br>\n";
    echo "Produkt: <strong>".$row['name']."</strong>";
?>

<br><br>Menge: <br>
        <input type="number" class="form-control" value="1" min="1" name="amount"/>

<br><br><strong>Adresse:</strong>

<?php
$user=1;
 $sql="SELECT * FROM user 
WHERE objectID = :user";
  $stmt=connectDB()->prepare($sql);
  $stmt->bindParam(":user", $user);
  $stmt->execute();

  while( $row=$stmt->fetch() ) {
      echo "<br>".$row['branchName'];
      echo "<br>".$row['street'];
      echo $row['houseNumber'];
      echo "<br>".$row['postCode']."&nbsp;";
      echo $row['city'];
      echo "<br>".$row['country'];
  }
?>

 <br><a href='change_address.php'>An eine andere Adresse liefern</a>
<br>
    <input type="hidden" name="update" value="<?php echo htmlspecialchars($_GET["update"]);?>">
    <input type='submit' name='order' value='Bestellen'>

</form>
</div>
</body>
</html>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>