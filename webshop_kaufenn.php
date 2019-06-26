<?php
require_once ("inc/include_db2.php");

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
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
    <title>Kurs</title>
    <link rel="stylesheet" href="css/style_css2.css">
</head>
<body>
    <?php

    if(isset($_POST['update'])){
        $name=$_POST['name'];
        $price=$_POST['price'];
        $description=$_POST['description'];
    }

    $sql='SELECT * FROM article WHERE objectID=:objectID';
    $stmt=$db->prepare($sql);
    $stmt->bindParam(':objectID',$objectID);
    $stmt->execute();

    $row=$stmt->fetch();
    echo "<h3>Artikel Bestellen:</h3><br>\n";
    echo "<strong>".$row['name']."</strong>";
?>

<br><br>Stückanzahl<br>
        <input type="number" class="form-control" value="1" name="amount"/>

<br><br><strong>Adresse:</strong>

<?php
 $sql2='SELECT * FROM user';
  $stmt2=$db->prepare($sql2);
  $stmt2->execute();

  $row=$stmt2->fetch();

  echo "<br>".$row['branchName'];
  echo "<br>".$row['street'];
  echo $row['houseNumber'];
  echo "<br>".$row['postCode']."&nbsp;";
  echo $row['city'];
  echo "<br>".$row['country'];
?>


 <br><a href='change_address.php'>An eine andere Adresse liefern</a>
<br>
<input type='submit' name='order' value='Bestellen'>




</body>
</html>