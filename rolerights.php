<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once 'include/constant.php';
$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_EDIT_PERM; //uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Rolle Rechtzuweisung"; // defines the name of the current page, displayed in the title and as a header on the page
require_once "include/init.php"; // includes base function like session handling
require_once "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
/*
if(!$perm->hasPermission(PERM_EDIT_PERM)){
    echo "Keine Berechtigung!<br>";
    die("Leider nicht.");
}*/

if(isset($_POST['saverolerights'])){
    unset($_POST['saverolerights']);
    
    try{
        $db = connectDB();
        $db->beginTransaction();
        $sql = "DELETE FROM rolesrights;"; #"TRUNICATE TABLE rolerights;";
        $db->query($sql);
        foreach ($_POST as $key=>$value){
            $tmpArr = explode("-", $key);
            $rightID = (int)$tmpArr[0];
            $roleID = (int)$tmpArr[1];
            $sql = "INSERT INTO rolesrights (rightsFID, rolesFID) VALUES(:rightsFID,:roleFID);";           
            $param = [":rightsFID"=>$rightID, ":roleFID"=>$roleID];
            $stmt = $db->prepare($sql);
            $stmt->execute($param);
        }
        
        $db->commit();
    }catch(Exception $ex){
        echo $ex;
        $db->rollBack();
    }
}

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="" method="post" name="rolerightsform">
        <div class="table-responsive">
            <table class="table table-bordered rrtable" id="rights" style="overflow: scroll;">
            <thead>
            <?php
                $sql = "SELECT r.objectID, r.name  FROM rights AS r ORDER BY objectID ASC;";
                $result = readDB($sql); #, NULL, PDO::FETCH_BOTH
                $columncount = 0;
                $tableStr = "<tr><th>&nbsp;</th>\n";
                $columncount = count($result);
                foreach ($result as $row) {
                    $tableStr .= "<th>$row[name]</th>\n";                    
                }
                $tableStr .= "</tr>\n</thead>\n<tbody>\n";
                $sql1 = "SELECT roles.objectID, roles.name FROM roles";
                $rolesList = readDB($sql1);
                foreach ($rolesList as $roleRow) {
                    $roleID = $roleRow["objectID"];
                    $sql = "SELECT 
                            rights.objectID AS THErightsID, 
                            rights.name AS rightsName,
                            auswahl.rolesFID AS haspermission,
                            auswahl.rightsFID AS rightsid
                            FROM rights LEFT JOIN
                            (SELECT 
                            rolesrights.rolesFID AS rolesFID, 
                            rolesrights.rightsFID AS rightsFID
                            FROM rolesrights 
                            WHERE rolesrights.rolesFID = :roleID ) 
                            AS auswahl
                            ON rights.objectID = auswahl.rightsFID
                            ORDER BY THErightsID;"; 
                    $param = [":roleID"=>$roleID];
                    $result = readDB($sql, $param);
                    $tableStr .= "<tr>\n<td>$roleRow[name]</td>\n";
                    
                    foreach ($result as $row) {
                        $checked = $row['haspermission'] != NULL ? "checked" : "";
                        $tableStr .= "<td><input type='checkbox' name='$row[THErightsID]-$roleID' $checked></td>\n";
                    }  
                    $tableStr .= "</tr>\n";
                }
                $columncount++;
                $tableStr .= "<tr><td colspan='$columncount' class='buttonrow'><input type='submit' name='saverolerights' value='Speichern' class='btn'></td></tr>\n";
                $tableStr .= "</tbody>\n";
                echo $tableStr;
            ?>
            </table>
            </div>
        </form>
    </div>
</div>
<script>
    $("#rights").dataTables();
</script>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
