<?php

session_start();
//array aus Session holen und zu weißen -> $whereIn
$whereIn = $_SESSION['cart'];

//Löschen von eintrag in array anhand der ID

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    unset($whereIn[$id]);


//Zurückschreiben des arrays in die Session
    $_SESSION['cart'] = $whereIn;

}

//Ausgabe des Arrays
foreach ($_SESSION['cart'] as $key => $value) {
    echo $value;
    echo "<a href='?id=$key'> delete</a>";
    echo "<br>";


}

?>
<br>
<a href="products.php">buy more!</a>



