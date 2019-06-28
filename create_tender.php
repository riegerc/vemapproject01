<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 0; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Ausschreibung erstellen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php";





?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
        <div class="content">
            <?php echo "<h6>". "AmsID : " . $_SESSION[USER_ID] . "<h6>". "<br>"; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                Ausschreibung : <input type="text" name="tender" class="form-control" placeholder="Titel der Ausschreibung... " required>
                <br>
                Ausschreibungs type :  <br><select name="tenderType" class="form-control">
                    <option name="Dienstleistung" value="Dienstleistung">
                        Dienstleistung
                    </option>
                    <option name="Lieferauftrag" value="Lieferauftrag">
                        Lieferauftrag
                    </option>

                </select>
                <br>
                Beginn : <input type="date" name="begin" class="form-control" required>
                <br>
                Ende : <input type="date" name="end" class="form-control" required>
                <br>
                Menge : <input type="number" name="amount" class="form-control" placeholder="Menge in Zahlen eintragen..." required>
                <br>

                <div class="form-group">
                    <label for="description">Auftragsbeschreibung :</label>
                    <textarea  name="description" class="form-control" placeholder="Beschreibung des Auftrags, inklusive Gruppen, Positionen und Langtexte..." rows="4"  data-error="Please, leave us a message."></textarea>

                </div>
                <br>
                <label>Upload für Ausschreibungs Excel
                </label><br> <input class="btn btn-primary" type="file" name="file"
                                    id="file" accept=".xls,.xlsx">
                <br>
                <br>
                <button type="submit" class="btn btn-primary" name="absenden">Ausschreibung erstellen</button>
                <button  type="reset" class="btn btn-danger"  >Formular zurücksetzen</button>
                <br>




        </div>
    </div>

<?php
if( isset($_POST["absenden"]) ){
    if( isset($_SESSION[USER_ID])){
    $userFID= $_SESSION[USER_ID];
    }
    $tender=$_POST["tender"];
    $tenderType=$_POST["tenderType"];
    $description=$_POST["description"];
    $begin= $_POST["begin"];
    $end= $_POST["end"];
    $amount=(int)$_POST["amount"];

    $sql="INSERT INTO tenders
                (tender,tenderType,cpvCode,begin,end,description,userFID,amount)
                VALUES
                (?,?,?,?,?,?,?,?)";
    $db = connectDB();
    $stmt=$db->prepare($sql);
    $stmt->execute(array($tender,$tenderType, "30000000-9" ,$begin,$end,$description,$userFID, $amount));
    $currentID = $db->lastInsertId();
    #-------------------------------------------------------



    /*$sql="SELECT * FROM tenders
                WHERE objectID = (
                SELECT MAX(objectID) FROM tenders)";
    $stmt=connectDB()->query($sql);
    $currentID=$stmt->fetch();*/
    #echo $currentID;


    foreach($_POST as $key => $value){
        if(strpos($key,"chkRole") > 0){
            #echo $value."<br>";
            $arr = explode("-",$value);
            $userFID=$arr[1];

        $sql="INSERT INTO supplierselect 
                    (tenderFID,userFID)
                    VALUES
                    (:currentID,:userFID)";
        $stmt=connectDB()->prepare($sql);
        $stmt->bindParam(":currentID",$currentID);
        $stmt->bindParam(":userFID",$userFID);
        $stmt->execute();
        }
    }





}?>



<?php
$conn= connectDB();
$showRecordPerPage = 5;
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = $_GET['page'];
}else{
    $currentPage = 1;
}
$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
$showRecordPerPage = 5;
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = $_GET['page'];
}else{
    $currentPage = 1;
}
$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
$totalEmpSQL = "SELECT count(*) FROM user LIMIT $startFrom, $showRecordPerPage";
#echo $totalEmpSQL;
$stmt = $conn->query($totalEmpSQL);
$allEmpResult = $stmt->fetch();
$totalEmployee = $allEmpResult[0];
$lastPage = ceil($totalEmployee/$showRecordPerPage);
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
    <table class="table ">
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
        while($emp = $stmt->fetch()){
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

        </form>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if($currentPage != $firstPage) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
                        <span aria-hidden="true">First</span>
                    </a>
                </li>
            <?php } ?>
            <?php if($currentPage >= 2) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
            <?php } ?>
            <li class="page-item active"><a class="page-link" href="?page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
            <?php if($currentPage != $lastPage) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
                        <span aria-hidden="true">Last</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <br>


<?php include "include/page/bottom.php";
?>