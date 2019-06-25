<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = true;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "Lieferant Ansicht";
include "snippets/header.php";
include "snippets/top.php";
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h5>Budget: 53,941 &euro;</h5>
            </div>
        </div>

        <h3>Produkt Verkaufen</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="product_name">
                        <small>Produktname</small>
                    </label>
                    <input type="text" class="form-control" name="product_name" id="product_name"/>
                </div>
                <!--dropdown for categories -->
                <div class="form-group col-sm-3">
                    <label for="product_type">
                        <small>Produkt-Typ</small>
                    </label>
                    <select class="form-control" name='product_type' id="product_type">
                        <optgroup label="Material:">
                            <option>Büromaterial</option>
                            <option>Reinigungsmittel</option>
                            <option>Elektronik & Computer</option>
                        </optgroup>
                        <optgroup label="Dienstleistung:">
                            <option>Kurse</option>
                            <option>Trainer</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="product_price">
                        <small>Preis</small>
                    </label>
                    <input class="form-control" type="number" name='product_price' id='product_price' min="0"/>
                </div>
                <div class="form-group col-sm-2">
                    <label for="product_stueck">
                        <small>Stückzahl</small>
                    </label>
                    <input class="form-control" type="number" name='product_stueck' id='product_stueck' min="0"/>
                </div>
                <div class="form-group col-sm-2" id="search-button-wrap">
                    <button class="btn btn-primary" type="submit" name="verkaufen" id="verkaufen">Verkaufen</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 table-responsive-lg">
                <table class="table table-bordered" id="search-results">
                    <?php
                    if (isset($_POST['verkaufen'])) {
                        echo "<h3>Meine Produkte</h3>";
                        echo "    <tr>\n";
                        echo "    <th>Produkt Name</th>\n";
                        echo "    <th>Kategorie</th>\n";
                        echo "    <th>Stück</th>\n";
                        echo "    <th>Preis</th>\n";
                        echo "    <th>Bearbeiten</th>\n";
                        echo "    <th>Löschen</th>\n";
                        echo "    </tr>";
                        $sql = "SELECT * FROM bestellungen";
                        foreach (connectDB()->query($sql) as $row) {
                            echo "    <tr>\n";
                            echo "    <td>" . $row['produktName'] . "</td>\n";
                            echo "    <td>" . $row['kategorie'] . "</td>\n";
                            echo "    <td>" . $row['stueck'] . "</td>\n";
                            echo "    <td>" . $row['preis'] . "</td>\n";
                            echo "    <td> <a href='#'>Bearbeiten</a><br>";
                            echo "    <td> <a href='#'>Löschen</a><br>";
                            echo "    </tr>";
                        }

                        $produktName = $_POST['product_name'];
                        $produktStueck = $_POST['product_stueck'];
                        $produktPreis = $_POST['product_price'];

                        $sql = "INSERT INTO bestellungen(produktName,stueck,preis)
                                VALUES(:produktName,:stueck,:preis)";

                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":produktName", $produktName);
                        $stmt->bindParam(":stueck", $produktStueck);
                        $stmt->bindParam(":preis", $produktPreis);
                        $stmt->execute();
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#search-results').DataTable();
</script>
<?php include "snippets/bottom.php"; ?>
