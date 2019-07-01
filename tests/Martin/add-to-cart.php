<?php
session_start();

if (empty($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

array_push($_SESSION['cart'], $_GET['id'])

?>

<p>

    Product added!
    <br>
    <a href="shopping-cart.php">view shopping cart</a>
</p>
