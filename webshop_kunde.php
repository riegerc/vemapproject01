<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

require_once ("include/database.php");
include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
    <?php


    //this variable is for the amount of results here. it scales with foreach loop below
    $counter=0;
    $db=connectDB();

//if suche button is clicked
if( isset ($_POST['suche_senden'])){
$vonPreis=$_POST['vonPreis'];
$bisPreis=$_POST['bisPreis'];
$product_type=$_POST['product_type'];
//GETS whats in the search input field
    $suche="%".$_POST['suche']."%";
//if search clicked ONLY THEN you get the table
echo "    <table>\n";
echo "    <tr>\n";
echo "    <th>Artikel Name</th>\n";
echo "    <th>Artikel Preis</th>\n";
echo "    <th>Artikel Gruppe</th>\n";
echo "    <th>Kaufen</th>\n";
echo "    </tr>";
}else{
    //this is empty for now
}
?>

<?php

    //sql statement for article!
    if(isset($_POST['suche'])){
        if(!empty($_POST['vonPreis'])){
            if(empty($_POST['bisPreis'])) {
              $bisPreis=1000000;
            }
            $sql="SELECT article.name,article.description,articlegroup.name,article.articleState FROM `article` LEFT JOIN articlegroup ON `articleGroupFID`=articlegroup.objectID
            WHERE (articlegroup.name=:product_type) AND (name LIKE :suche) AND (price BETWEEN :vonPreis AND :bisPreis)";
    $stmt=$db->prepare($sql);
    $stmt->bindParam(":product_type",$product_type);
    $stmt->bindParam(':vonPreis',$vonPreis);
    $stmt->bindParam(':bisPreis',$bisPreis);
    $stmt->bindParam(":suche",$suche);
    $stmt->execute();
    $output="";


    //this is the counter for the amount of results you get

        //foreach loop for the table rows
     foreach($stmt as $row){
            echo "    <tr>\n";
            echo "    <td>".$row['name']."</td>\n";
            echo "    <td>".$row['price']."&euro;"."</td>\n";
            echo "    <td>".$row['description']."</td>\n";
            echo "    <td> <a href='webshop_kaufenn.php?update=".$row['objectID']."'>Kaufen</a><br>";
            echo "    </tr>";
  //this variable counts each time you get a result from search.
            $counter++  ;}
     }else{
           $sql="SELECT * FROM article
    WHERE (description=:product_type) AND (name LIKE :suche)";

            $stmt=$db->prepare($sql);
            $stmt->bindParam(":product_type",$product_type);
            $stmt->bindParam(":suche",$suche);
            $stmt->execute();


    //this is the counter for the amount of results you get

        //foreach loop for the table rows
     foreach($stmt as $row){
            echo "    <tr>\n";
            echo "    <td>".$row['name']."</td>\n";
            echo "    <td>".$row['price']."&euro;"."</td>\n";
            echo "    <td>".$row['description']."</td>\n";
            echo "    <td> <a href='webshop_kaufenn.php?update=".$row['objectID']."'>Kaufen</a><br>";
            echo "    </tr>";
  //this variable counts each time you get a result from search.
            $counter++  ;}
        }
    }
    /*$sql="SELECT * FROM article
    WHERE (description=:product_type) AND (name LIKE :suche) AND (price BETWEEN :vonPreis AND :bisPreis)";*/

     ?>

<!--start of HTML-->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
    <link rel="stylesheet" href="css/style_css2.css">
    <title>Kurs</title>

</head>
<body>

<!--first header + budget-->
<h3>Kunde Ansicht</h3> <h3>Budget: 941.64&euro;</h3>

<!-- search input bar-->
<input type="text" class="form-control" name="suche" placeholder='Produktname'id="suche"/>

<!--dropdown for categories -->
<select name='product_type'>
    <optgroup label="Material:">
    <option>Büroartikel</option>
    <option>Reinigungsmittel</option>
    <option>Computer&Zubehör</option>
    <optgroup label="Dienstleistung:">
    <option>Kurse</option>
    <option>Trainer</option>
</select>
 <!--search by manual price input (doesnt work yet)-->
<input type="number" name='vonPreis' placeholder='Preis von'/>-<input type="number" name='bisPreis' placeholder='Preis bis'/>

<input type="submit" class="form-control" name="suche_senden" id="suche_senden" value='Suchen!'/><br>
 <!--search by manual price input -->



    <?php

                 //if suchen is clicked
                if(isset($_POST['suche_senden'])){

        //if the counter counts 0 results. aka no results then you have the ability to ORDER
        if($counter==0){
            echo "Keine Ergebnisse gefunden. <a href='webshop_bestellen.php'>Jetzt Bestellen</a>";
        }else{
            //if the counter isnt 0 then you get the ability to BUY the items which you found
            echo $counter;
            echo " Ergebnisse!";
    }
        }?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
