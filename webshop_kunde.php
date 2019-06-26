<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Kunde Ansicht"; // defines the name of the current page, displayed in the title and as a header on the page

require_once("include/database.php");
include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <h5>Budget: 941.64&euro;</h5>
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
                            <optgroup label="Material:">
                                <option>Büroartikel</option>
                                <option>Reinigungsmittel</option>
                                <option>Computer&Zubehör</option>
                            </optgroup>
                            <optgroup label="Dienstleistung:">
                                <option>Kurse</option>
                                <option>Trainer</option>
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
                <div class="form-group col-md-2" id="search-button-wrap">
                    <input type="submit" class="btn btn-primary" name="suche_senden" id="suche_senden" value='Suchen'/><br>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="search_results">
                <?php
                //this variable is for the amount of results here. it scales with foreach loop below
                $counter = 0;
                $db = connectDB();

                if (isset ($_POST['suche_senden'])) {
                    $vonPreis = $_POST['vonPreis'];
                    $bisPreis = $_POST['bisPreis'];
                    $product_type = $_POST['product_type'];

                    //GETS whats in the search input field
                    $suche = "%" . $_POST['suche'] . "%";

                    //if search clicked ONLY THEN you get the table
                    echo "    <tr>\n";
                    echo "    <th>Artikel Name</th>\n";
                    echo "    <th>Artikel Preis</th>\n";
                    echo "    <th>Artikel Gruppe</th>\n";
                    echo "    <th>Kaufen</th>\n";
                    echo "    </tr>";
                }

                //sql statement for article
                if (isset($_POST['suche'])) {
                    if (!empty($_POST['vonPreis'])) {
                        if (empty($_POST['bisPreis'])) {
                            $bisPreis = 1000000;
                        }
                        $sql = "SELECT * FROM `article`
                                WHERE (description=:product_type) 
                                AND (name LIKE :suche) 
                                AND (price BETWEEN :vonPreis AND :bisPreis)";
                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":product_type", $product_type);
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
                            echo "    <td> <a href='webshop_kaufenn.php?update=" . $row['objectID'] . "'>Kaufen</a><br>";
                            echo "    </tr>";
                            //this variable counts each time you get a result from search.
                            $counter++;
                        }
                    } else {
                        $sql = "SELECT * FROM article
                        WHERE (description=:product_type) AND (name LIKE :suche)";

                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":product_type", $product_type);
                        $stmt->bindParam(":suche", $suche);
                        $stmt->execute();

                        //this is the counter for the amount of results you get
                        //foreach loop for the table rows
                        foreach ($stmt as $row) {
                            echo "    <tr>\n";
                            echo "    <td>" . $row['name'] . "</td>\n";
                            echo "    <td>" . $row['price'] . "&euro;" . "</td>\n";
                            echo "    <td>" . $row['description'] . "</td>\n";
                            echo "    <td> <a href='webshop_kaufenn.php?update=" . $row['objectID'] . "'>Kaufen</a><br>";
                            echo "    </tr>";
                            //this variable counts each time you get a result from search.
                            $counter++;
                        }
                    }
                }

                if (isset($_POST['suche_senden'])) {
                    if ($counter == 0) {
                        echo "Keine Ergebnisse gefunden. <a href='webshop_bestellen.php'>Jetzt Bestellen</a>";
                    } else {
                        echo $counter;
                        echo " Ergebnisse!";
                    }
                } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#search-results').DataTable();
</script>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
