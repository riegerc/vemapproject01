<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "Webshop - Kunde";
include "snippets/header.php";
include "snippets/top.php";
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h5>Budget: 941.64 &euro;</h5>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="suche">
                        <small>Produktname</small>
                    </label>
                    <input type="text" class="form-control" name="suche" id="suche"/>
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
                    <label for="vonPreis">
                        <small>Preis von</small>
                    </label>
                    <input class="form-control" type="number" name='vonPreis' id='vonPreis' min="0"/>
                </div>
                <div class="form-group col-sm-2">
                    <label for="bisPreis">
                        <small>Preis bis</small>
                    </label>
                    <input class="form-control" type="number" name='bisPreis' id='bisPreis' min="0"/>
                </div>
                <div class="form-group col-sm-2" id="search-button-wrap">
                    <button class="btn btn-primary" type="submit" name="suche_senden" id="suche_senden">Suchen</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 table-responsive-lg">
                <table class="table table-bordered" id="search-results">
                    <?php
                    $counter = 0;

                    //if suche button is clicked
                    if (isset ($_POST['suche_senden'])) {
                        //GETS whats in the search input field
                        $suche = "%" . $_POST['suche'] . "%";
                        //if search on ONLY THEN you get the table
                        echo "<tr>\n";
                        echo "<th>ID</th>\n";
                        echo "<th>ArtikelName</th>\n";
                        echo "<th>ArtikelGruppe</th>\n";
                        echo "<th>ArtikelPreis</th>\n";
                        echo "<th>ArtikelBeschreibung</th>\n";
                        echo "<th>ArtikelStatus</th>\n";
                        echo "<th>Kaufen</th>\n";
                        echo "</tr>";
                        //outputs the amount of results you got, counter counts in foreach loop down below
                    }

                    //sql statement for artikel
                    $sql = "SELECT * FROM artikel
                            WHERE artikelName 
                            LIKE :suche OR artikelGruppe LIKE :suche OR artikelBeschreibung LIKE :suche";
                    $stmt = connectDB()->prepare($sql);
                    $stmt->bindParam(":suche", $suche);
                    $stmt->execute();

                    $output = "";
                    //foreach loop for the table rows
                    foreach ($stmt as $row) {
                        echo "<tr>\n";
                        echo "<td>" . $row['artikelID'] . "</td>\n";
                        echo "<td>" . $row['artikelName'] . "</td>\n";
                        echo "<td>" . $row['artikelGruppe'] . "</td>\n";
                        echo "<td>" . $row['artikelPreis'] . "</td>\n";
                        echo "<td>" . $row['artikelBeschreibung'] . "</td>\n";
                        echo "<td>" . $row['artikelStatus'] . "</td>\n";
                        echo "<td> <a href='#'>Kaufen</a><br>";
                        echo "</tr>";
                        //counter counts
                        $counter++;
                    }
                    echo $counter;
                    echo " Ergebnisse";
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

