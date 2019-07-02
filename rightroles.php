<?php
/**
 * @author Christian Rieger
 */
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once 'include/constant.php';
$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_VIEW_PERMISSIONS; //uses a PERM_ const now and hasPermission($userLevel) now if fails  a 403 Error-Page is returned # #PERM_EDIT_PERM
$title = "Rechte und Rollenzuweisung"; // defines the name of the current page, displayed in the title and as a header on the page
require_once "include/init.php"; // includes base function like session handling
require_once "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
$selRoleId  = -1;
$selRoleSel = 0;
$selRightId = -1;
$selRightSel = 0;
if(isset($_GET['selRoleId']) && isset($_GET['selRoleSel'])){
    $selRoleId = (int)$_GET['selRoleId'];
    $selRoleSel = (int)$_GET['selRoleSel'];
    $selRoleSel = $selRoleSel > 0 ? 0 : 1;
}
if(isset($_GET['selRightId']) && isset($_GET['selRightSel'])){
    $selRightId = (int)$_GET['selRightId'];
    $selRightSel = (int)$_GET['selRightSel'];
    $selRightSel = $selRightSel > 0 ? 0 : 1;
}
$hasEditPermission = $perm->hasPermission(PERM_EDIT_PERM); #has user edit permission?

if(isset($_POST['saverolerights']) && $hasEditPermission){    
    unset($_POST['saverolerights']);
    
    try{
        $db = connectDB();
        $db->beginTransaction();
        $sql = "DELETE FROM rolesrights;"; #"TRUNICATE TABLE rolerights;";
        $db->query($sql);
        
        foreach ($_POST as $key=>$value){            
            $tmpArr = explode("-", $key);
            $rightID = (int)$tmpArr[1];
            $roleID = (int)$tmpArr[0];
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
            <table class="table table-bordered table-striped table-hover rrtable" id="rights" style="overflow: scroll;">
            <thead>
            <?php
                $sql = "SELECT r.objectID, r.name  FROM roles AS r ORDER BY r.name ASC;";
                $result = readDB($sql); #, NULL, PDO::FETCH_BOTH
                $columncount = 0;
                $tableStr = "<tr><td>&nbsp;</td>\n";
                $columncount = count($result);
                foreach ($result as $row) {
                    if(SHOW_SELECT_ALL_LINKS != 0){
                        $tableStr .= "<td><a href='?selRoleId=$row[objectID]&selRoleSel=$selRoleSel'>$row[name]</a></td>\n";    
                    } else {
                        $tableStr .= "<td>$row[name]</td>\n";  
                    }               
                }
                $tableStr .= "</tr>\n</thead>\n<tbody>\n";
                $sql1 = "SELECT rights.objectID, rights.name FROM rights";
                $rolesList = readDB($sql1);
                foreach ($rolesList as $roleRow) {
                    $rightID = $roleRow["objectID"];
                    $sql = "SELECT 
                            roles.objectID AS THErolesID, 
                            roles.name AS rolesName,
                            auswahl.rightsFID AS haspermission,
                            auswahl.rolesFID AS rolesid
                            FROM roles LEFT JOIN
                            (SELECT 
                            rolesrights.rolesFID AS rolesFID, 
                            rolesrights.rightsFID AS rightsFID
                            FROM rolesrights 
                            WHERE rolesrights.rightsFID = :rightID ) 
                            AS auswahl
                            ON roles.objectID = auswahl.rolesFID
                            ORDER BY rolesName, THErolesID;"; 
                    $param = [":rightID"=>$rightID];
                    $result = readDB($sql, $param);
                    if(SHOW_SELECT_ALL_LINKS != 0){
                        $tableStr .= "<tr>\n<td><a href='?selRightId=$rightID&selRightSel=$selRightSel' >$roleRow[name]</a></td>\n";
                    }else {
                        $tableStr .= "<tr>\n<td>$roleRow[name]</td>\n";
                    }
                    
                    foreach ($result as $row) {
                        $checked = $row['haspermission'] != NULL ? "checked" : "";
                        if($selRoleId > 0 ){
                            if($selRoleId == $row['THErolesID'] ){
                                if($selRoleSel > 0)
                                    $checked = "checked";
                                else
                                    $checked = "";
                            }
                        }
                        if($selRightId > 0 ){
                            if($selRightId == $rightID ){
                                if($selRightSel > 0)
                                    $checked = "checked";
                                else
                                    $checked = "";
                            }
                        }
                        if($hasEditPermission){
                            $deactivated = "";
                        }else {
                            $deactivated = "disabled ";
                        }
                        $tableStr .= "<td><input type='checkbox' name='$row[THErolesID]-$rightID' $checked $deactivated></td>\n";
                    }  
                    $tableStr .= "</tr>\n";
                }
                $columncount++;
                if($hasEditPermission){
                    $deactivated = "";
                }else {
                    $deactivated = "disabled ";
                }
                $tableStr .= "<tr><td colspan='$columncount' class='buttonrow'><input type='submit' name='saverolerights' value='Speichern' class='btn' $deactivated></td></tr>\n";
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
