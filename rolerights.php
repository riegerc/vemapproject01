<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Rolle Rechtzuweisung"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="" method="post" name="rolerightsform">
            <table class="table table-bordered" id="rights" style="overflow: scroll;">
            <?php
                $sql = "SELECT r.objectID, r.name  FROM rights AS r ORDER BY objectID ASC;";
                $result = readDB($sql); #, NULL, PDO::FETCH_BOTH
                #var_dump($result);
                $rightArr = [];
                $rowTemplateArr = [];
                $tableStr = "<tr><th>&nbsp;</th>\n";
                foreach ($result as $row) {
                    $tableStr .= "<td>$row[name]</td>";
                    $rightArr[$row['objectID']] = $row['name'];
                    $rowTemplateArr[$row['objectID']] = 0;
                }
                $tableStr .= "</tr>\n";
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
                    $tableStr .= "<tr><td>$roleRow[name]</td>";
                    $tmpArr = new ArrayObject($rowTemplateArr);
                    foreach ($result as $row) {
                        $checked = $row['haspermission'] == 1 ? "checked" : "";
                        $tableStr .= "<td><input type='checkbox' id='x' $checked></td><tr>";
                    }  
                    $tableStr .= "</tr>";
                }
                echo $tableStr;
            ?>
            </table>
        </form>
    </div>
</div>
<script>
    $("#rights").dataTables();
</script>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
