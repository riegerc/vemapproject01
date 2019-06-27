<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 0; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Ausschreibungen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php";

if (isset($_POST["send"])) {
    if (isset($_POST["search"]) AND $_POST["search"] != "") {
        $search = ("%" . htmlspecialchars($_POST["search"]) . "%");
    } else {
        if (isset($_POST["branchName"])) {
            $branchName = (htmlspecialchars($_POST["branchName"]));
        } else {
            $branchName = "";
        }
        if (isset($_POST["tenderTyp"])) {
            $tenderTyp = (htmlspecialchars($_POST["tenderTyp"]));
        } else {
            $tenderTyp = "";
        }
        if (isset($_POST["dfrom"])) {
            $dFrom = $_POST["dfrom"];
        }
        if (isset($_POST["dto"]) AND $_POST["dto"] != "") {
            $dEnd = $_POST["dto"];
        } else {
            $dEnd = "";
        }
        if ($_POST["search"] == ""
            AND $_POST["dfrom"] == ""
            AND $_POST["dto"] == ""
            AND $branchName == ""
            AND $tenderTyp == "") {
            $search = "%%";
        }
    }
} else {
    $search = "%%";
}
?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
        <div class="content">
            <form class="suche" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search">Suche</label>
                        <input type="text" id="search" class="form-control" name="search"
                               placeholder="DocNr. oder Auftragsbezeichung...">
                    </div>
                    <div class="col-sm-3">
                        <label>Auftraggeber</label>
                        <select class="form-control" name='branchName' id='bName'>
                            <?php
                            $sql = "SELECT branchName FROM user GROUP BY branchName";
                            $stmt = connectDB()->query($sql);
                            echo "<option value='' selected disabled='disabled'>Auswählen...</option>>";
                            while ($row = $stmt->fetch()) {
                                echo "<option value='$row[branchName]'>$row[branchName]</option>>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <label>von</label>
                        <input type="date" class="form-control" name="dfrom" placeholder="von...">
                    </div>
                    <div class="col-sm-1">
                        <label>bis</label>
                        <input type="date" class="form-control" name="dto" placeholder="bis...">
                    </div>
                    <div class="col-md-2">
                        <label>Art des Auftrags</label>
                        <select class="form-control" name='tenderTyp' id='orderType'>
                            <?php
                            $sql = "SELECT tenderType FROM tenders GROUP BY tenderType";
                            $stmt = connectDB()->query($sql);
                            echo "<option value='' selected disabled='disabled'>Auswählen...</option>>";

                            while ($row = $stmt->fetch()) {
                                echo "<option value='$row[tenderType]'>$row[tenderType]</option>>";

                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-button-wrap">
                        <input type="submit" class="btn btn-primary form-button" name="send" value="Suchen">
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 table-responsive-lg">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <th>Dok. Nr.</th>
                    <th>Bezeichnung des Auftrags</th>
                    <th>Auftraggeber</th>
                    <th>Zeitraum</th>
                    <th>Schlusstermin</th>
                    </thead>
                    <?php
                    $sql = "SELECT tenders.objectID AS DocNumber, 
                               tenders.tender, 
                               tenders.description,
                               tenders.tenderType,
                               user.branchName AS branchName,
                               tenders.begin,
                               tenders.end
                        FROM tenders
                        LEFT JOIN user ON tenders.userFID = user.objectID 
                        WHERE tenders.objectID LIKE :search 
                        OR tenders.tender LIKE :search
                        OR tenders.tenderType LIKE :tenderTyp
                        OR user.branchName LIKE :branchName
                        OR tenders.begin LIKE :dateBegin
                        OR tenders.end LIKE :dateEnd";

                    $stmt = connectDB()->prepare($sql);
                    $stmt->bindParam(":search", $search);
                    $stmt->bindParam(":tenderTyp", $tenderTyp);
                    $stmt->bindParam(":branchName", $branchName);
                    $stmt->bindParam(":dateBegin", $dFrom);
                    $stmt->bindParam(":dateEnd", $dEnd);
                    $stmt->execute();

                    while ($row = $stmt->fetch()) {
                        $bdate = date_create($row["begin"]);
                        $edate = date_create($row["end"]);

                        echo "<tr>";
                        echo "<td>" . $row["DocNumber"] . "</td>";
                        echo "<td> <a href='tender_detail.php?tenderID=$row[DocNumber]'>$row[tender]</a> </td>";
                        echo "<td>" . $row["branchName"] . "</td>";
                        echo "<td>" . date_format($bdate, 'd.m.Y') . "</td>";
                        echo "<td>" . date_format($edate, 'd.m.Y') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#search-results').DataTable();
    </script>
<?php include "include/page/bottom.php"; ?>