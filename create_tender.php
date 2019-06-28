<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Ausschreibung erstellen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)


if (isset($_POST["absenden"])) {
    if (isset($_SESSION[USER_ID])) {
        $userFID = $_SESSION[USER_ID];
    }
    $tender = $_POST["tender"];
    $tenderType = $_POST["tenderType"];
    $description = $_POST["description"];
    $begin = $_POST["begin"];
    $end = $_POST["end"];
    $amount = (int)$_POST["amount"];

    $sql = "INSERT INTO tenders
                (tender,tenderType,cpvCode,begin,end,description,userFID,amount)
                VALUES
                (?,?,?,?,?,?,?,?)";
    $db = connectDB();
    $stmt = $db->prepare($sql);
    $stmt->execute(array($tender, $tenderType, "30000000-9", $begin, $end, $description, $userFID, $amount));
    $currentID = $db->lastInsertId();

    foreach ($_POST as $key => $value) {
        if (strpos($key, "chkRole") > 0) {
            #echo $value."<br>";
            $arr = explode("-", $value);
            $userFID = $arr[1];

            $sql = "INSERT INTO supplierselect 
                    (tenderFID,userFID)
                    VALUES
                    (:currentID,:userFID)";
            $stmt = connectDB()->prepare($sql);
            $stmt->bindParam(":currentID", $currentID);
            $stmt->bindParam(":userFID", $userFID);
            $stmt->execute();
        }
    }
}

$conn = connectDB();
$showRecordPerPage = 5;
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
$showRecordPerPage = 5;
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
$totalEmpSQL = "SELECT count(*) FROM user LIMIT $startFrom, $showRecordPerPage";
#echo $totalEmpSQL;
$stmt = $conn->query($totalEmpSQL);
$allEmpResult = $stmt->fetch();
$totalEmployee = $allEmpResult[0];
$lastPage = ceil($totalEmployee / $showRecordPerPage);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;
#"SELECT user.objectID, user.firstName, user.lastName FROM user LIMIT $startFrom, $showRecordPerPage";
$empSQL = "SELECT objectID, firstName, lastName , branchName , rolesFID 
FROM `user`
WHERE rolesFID=6 OR rolesFID=4 
 LIMIT $startFrom, $showRecordPerPage";
$stmt = $conn->query($empSQL);
#$empResult = $stmt->fetch();

?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
        <div class="content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php echo "<h6>" . "AmsID : " . $_SESSION[USER_ID] . "<h6>" . "<br>"; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ausschreibung</label>
                    <input type="text" name="tender" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ausschreibungs type</label>
                    <select name="tenderType" class="form-control">
                        <option name="Dienstleistung" value="Dienstleistung">
                            Dienstleistung
                        </option>
                        <option name="Lieferauftrag" value="Lieferauftrag">
                            Lieferauftrag
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Beginn</label>
                    <input type="date" name="begin" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ende</label>
                    <input type="date" name="end" class="form-control">
                </div>
                <div class="form-group">
                    <label>Menge</label>
                    <input type="number" name="amount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Auftragsbeschreibung</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Upload für Ausschreibungs Excel</label>
                    <input class="form-control-file" type="file" name="file" id="file" accept=".xls,.xlsx">
                </div>
                <div class="table-responsive-lg">
                    <table class="table table-bordered table-striped table-hover" id="shortTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>branchName</th>
                            <th>firstName</th>
                            <th>lastName</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php

                            # var_dump($allEmpResult);
                            while ($emp = $stmt->fetch()) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $emp['objectID']; ?></th>
                                    <?php
                                    echo "<th> <input type='checkbox' name='$emp[objectID]chkRole' value='$emp[rolesFID]-$emp[objectID]'></th>";
                                    #echo "<input type='hidden' name='objectID[]' value='$emp[objectID]'>\n";
                                    ?>

                                    <td><?php echo $emp['branchName']; ?></td>
                                    <td><?php echo $emp['firstName']; ?></td>
                                    <td><?php echo $emp['lastName']; ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-button" name="absenden">Ausschreibung
                        erstellen
                    </button>
                </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-danger form-button">Formular zurücksetzen</button>
                </div>
            </div>
        </div>
    </form>
        </div>
    </div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. )
?>
?>