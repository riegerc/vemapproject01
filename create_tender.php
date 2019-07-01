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
WHERE rolesFID=6 OR rolesFID=4";
$stmt = $conn->query($empSQL);
#$empResult = $stmt->fetch();

?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <?php
        echo "<span style='display: none;' id='transferToJavaScript'>" . json_encode($stmt->fetchAll()) . "</span>";
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php echo "<h6>" . "AmsID : " . $_SESSION[USER_ID] . "<h6>" . "<br>"; ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ausschreibung</label>
                        <input type="text" name="tender" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ausschreibungs type</label>
                        <select name="tenderType" class="form-control" required>
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
                        <input type="date" name="begin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ende</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Auftragsbeschreibung</label>
                        <textarea name="description" class="form-control" rows="7" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ergänzende PDF Dokumente hinzufügen (max. 25mb)</label>
                        <input name="datei[]" class="form-control-file" type="file" multiple size="25" accept=".pdf">
                        <!-- TODO muss noch mit Formular mitgesendet und auf Server gespeichert werden-->
                    </div>
                    <div class="form-group">
                        <label>Upload für Ausschreibungs Excel</label>
                        <input class="form-control-file" type="file" name="file" id="file" accept=".csv,.xls,.xlsx">
                    </div>
                </div>
                <div class="col-md-6">
                       <div class="table-responsive-lg">
                        <table class="table table-bordered table-striped table-hover" :id="tableName">
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
                            <tr v-for="branch in branches">
                                <td v-text="branch.objectID"></td>
                                <th>
                                    <input type='checkbox'
                                           v-model='branchCheckboxes[branch.objectID]'>
                                </th>
                                <td v-text="branch.branchName"></td>
                                <td v-text="branch.firstName"></td>
                                <td v-text="branch.lastName"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="display: none;">
                            <tr v-for="branch in branches">
                                <td v-text='branch.objectID'></td>
                                <th>
                                    <input type='checkbox'
                                           v-model='branchCheckboxes[branch.objectID]'
                                           :name='branch.objectID + "chkRole"'
                                           :value='branch.rolesFID + "-" + branch.objectID'>
                                </th>
                                <td v-text="branch.branchName"></td>
                                <td v-text="branch.firstName"></td>
                                <td v-text="branch.lastName"></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-button" name="absenden">
                            <i class="fas fa-check"></i> Ausschreibung erstellen
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger form-button">
                            <i class="fas fa-undo-alt"></i> Formular zurücksetzen
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
