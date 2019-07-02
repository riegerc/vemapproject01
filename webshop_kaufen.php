<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Produkt bestellen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

 if (isset($_GET['update'])) {
    $objectID = (int)$_GET['update'];
    $_SESSION['artikelID']=$objectID;
} else if (isset($_POST['update'])) {
    $objectID = (int)$_POST['objectID'];
    $_SESSION['artikelID']=$objectID;
} else {
    exit("Kein Objekt gewählt");
} 
?>
<!-- update -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <form action="artikel_kaufen.php" method="post">
        <div class="row">
            <div class="col-md-12">
                <?php
        
              /* brauchen wir nicht da wir es über das sql statment eh reinholen kann
              derzeit wird nur der article name verwendet, die Frage die sich stellt ist brauch ma die anderen Angaben
              wenn ja geb ma die beiden nach den Select noch ein article.price, article.description 
               if (isset($_POST['update'])) {
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $description = $_POST['description'];
                }*/
                $sql = "SELECT article.name, article.price, article.description 
                FROM article 
                WHERE article.objectID =  :objectID";
                $stmt = connectDB()->prepare($sql);
                $stmt->bindParam(":objectID", $objectID);
                $stmt->execute();
                $row = $stmt->fetch();
                ?>
                <span style="display: none" id="customerBuyPrice"><? echo $row['price'] ?></span>
                <div class="row">
                    <div class="col-md-3">
                        <label>Produkt</label>
                        <h4><?php echo $row['name'] ?></h4>
                    </div>
                    <div class="col-md-3">
                        <label>Preis</label>
                        <h4><?php echo number_format($row['price'],2,',','\'')." €"; ?></h4>
                    </div>
                    <div class="col-md-3">
                        <label>Beschreibung</label>
                        <h4><?php echo $row['description'] ?></h4>
                    </div>
                    <div class="col-md-3 float-right">
                        <div class="form-group">
                            <label>Menge</label>
                            <input type="number" class="form-control" value="1" min="1" max="999999999" name="amount" v-model="customerBuyAmount"/>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <label>Summe</label>
                        <h4 v-text="Intl.NumberFormat('de-DE', {style: 'decimal'}).format(customerBuyPrice * customerBuyAmount) + ' €'"></h4>
                    </div>
                </div>
                <hr>
                <h5>Adresse</h5>
                <div class="card">
                    <div class="card-body">
                        <?php
                        $user = $_SESSION[USER_ID];
                        $sql = "SELECT user.branchName, user.street, user.houseNumber, user.postCode, user.city, user.country 
                        FROM user
                        WHERE user.objectID = :user";
                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":user", $user);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo $row['branchName'];
                            echo "<br>" . $row['street'] . " " . $row['houseNumber'];
                            echo "<br>" . $row['postCode'] . "&nbsp;";
                            echo $row['city'];
                            echo "<br>" . $row['country'];
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <input type="hidden" name="update" value="<?php echo htmlspecialchars($_GET["update"]); ?>">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-info form-button" href='webshop_change_delivery_address.php'>
                            <i class="fas fa-map-marker-alt"></i> An eine andere Adresse liefern
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type='submit' name='order' class="btn btn-primary form-button">
                            <i class="fas fa-shopping-cart"></i> Bestellen
                        </button>
                    </div>
                </div><!-- Buttons-->
            </div>
        </div>
    </form>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>

