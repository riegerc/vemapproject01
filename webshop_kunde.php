<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Webshop"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
    <?php 
        //dropDown articlegroup
        $sql="SELECT articlegroup.name, articlegroup.objectID FROM articlegroup WHERE articlegroup.service=0";
        $stmt = connectDB()->query($sql);
        $grouparticle="";
        foreach($stmt as $row){
            $grouparticle.= "<option value='".$row['objectID']."'>".$row['name']."</option>";
        }
        //dropDown servicegroup
        $sql="SELECT articlegroup.name, articlegroup.objectID FROM articlegroup WHERE articlegroup.service=1";
        $stmt = connectDB()->query($sql);
        $groupservice="";
        foreach($stmt as $row){
            $groupservice.= "<option value='".$row['objectID']."'>".$row['name']."</option>";
        }
        //budget
        $sql="SELECT user.budget FROM user WHERE user.objectID=".$_SESSION[USER_ID]."";
        $stmt = connectDB()->query($sql);
        $budget="";
        foreach($stmt as $row){
            $budget.= $row['budget'];
        }
        ?>
        <h5>Budget: <?php echo  number_format($budget,2,',','.'); ?> &euro;</h5>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="suche">Produktname</label>
                        <input type="text" class="form-control" name="suche" id="suche"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="product_type">Produkt-Typ</label>
                        <select name='product_type' id='product_type' class="form-control">
                            <optgroup label="Material">
                                <?php echo $grouparticle; ?>
                            </optgroup>
                            <optgroup label="Dienstleistung">
                                <?php echo $groupservice; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="vonPreis">Preis von</label>
                    <input type="number" name='vonPreis' id='vonPreis' class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="bisPreis">Preis bis</label>
                    <input type="number" name='bisPreis' id='bisPreis' class="form-control">
                </div>
                <div class="form-group col-md-2 form-button-wrap" >
                    <input type="submit" class="btn btn-primary form-button" name="suche_senden" id="suche_senden" value='Suchen'/><br>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <?php
                //this variable is for the amount of results here. it scales with foreach loop below
                $counter = 0;

                if (isset ($_POST['suche_senden'])) {
                    echo "<table class='table table-bordered table-striped table-hover' id='dataTable'>";
                    $vonPreis = $_POST['vonPreis'];
                    $bisPreis = $_POST['bisPreis'];
                    $product_type = $_POST['product_type'];

                    //GETS whats in the search input field
                    $suche = "%" . $_POST['suche'] . "%";

                    //if search clicked ONLY THEN you get the table
                    echo "    <thead><tr>\n";
                    echo "    <th>Artikel Name</th>\n";
                    echo "    <th>Artikel Preis</th>\n";
                    echo "    <th>Artikel Gruppe</th>\n";
                    echo "    <th>Lieferant</th>\n";
                    echo "    <th>Kaufen</th>\n";
                    echo "    </tr></thead>";
                }

                //sql statement for article
                if (isset($_POST['suche'])) {
                    if (!empty($_POST['vonPreis'])) {
                        if (empty($_POST['bisPreis'])) {
                            $bisPreis = 1000000;
                        }
                        $sql = "SELECT article.objectID as articleID, article.name, article.price, article.description, user.branchName as branch FROM `article`
                                LEFT JOIN user ON article.supplierUserFID=user.objectID
                                WHERE (article.articleGroupFID=:group) 
                                AND (name LIKE :suche) 
                                AND (price BETWEEN :vonPreis AND :bisPreis)";
                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":group", $product_type);
                        $stmt->bindParam(':vonPreis', $vonPreis);
                        $stmt->bindParam(':bisPreis', $bisPreis);
                        $stmt->bindParam(":suche", $suche);
                        $stmt->execute();
                        
                        //this is the counter for the amount of results you get

                        //foreach loop for the table rows
                        foreach ($stmt as $row) {
                            echo "    <tr>\n";
                            echo "    <td>" . $row['name'] . "</td>\n";
                            echo "    <td>" . $row['price'] . "&euro;" . "</td>\n";
                            echo "    <td>" . $row['description'] . "</td>\n";
                            echo "    <td>".$row['branch']."</td>\n";
                            echo "    
                            <td> 
                            <form action='webshop_kaufen.php' method='post'>
                            <button type='submit' name='update' value='$row[objectID]' class='btn btn-alert form-button'>
                                <i class='fas fa-shopping-cart'></i>            
                            </button>
                            </form>";
                            echo "    </tr>";
                            //this variable counts each time you get a result from search.
                            $counter++;
                        }
                    } else {
                        $sql = "SELECT article.objectID, article.name as name, article.price as price, article.description as description, user.branchName as branch 
                        FROM `article`
                        LEFT JOIN user ON article.supplierUserFID=user.objectID
                        WHERE (article.articleGroupFID=:group) AND (name LIKE :suche)";

                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":group", $product_type);
                        $stmt->bindParam(":suche", $suche);
                        $stmt->execute();

                        //this is the counter for the amount of results you get
                        //foreach loop for the table rows
                        foreach ($stmt as $row) {
                            echo "    <tr>\n";
                            echo "    <td>" . $row['name'] . "</td>\n";
                            echo "    <td>" . $row['price'] . "&euro;" . "</td>\n";
                            echo "    <td>" . $row['description'] . "</td>\n";
                            echo "    <td>".$row['branch']."</td>\n";
                            echo "
                            <td> 
                            <form action='webshop_kaufen.php' method='post'>
                            <button type='submit' name='update' value='$row[objectID]' class='btn btn-alert form-button'>
                                <i class='fas fa-shopping-cart'></i>            
                            </button>
                            </form>";
                            echo "    </tr>";
                            //this variable counts each time you get a result from search.
                            $counter++;
                        }
                    }
                    echo "</table>";
                }

                if (isset($_POST['suche_senden'])) {
                    if ($counter == 0) {
                        echo "Keine Ergebnisse gefunden.";
                    } else {
                        echo "$counter Ergebnisse";
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
<br>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
