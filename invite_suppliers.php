<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
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
WHERE rolesFID=10
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
                    echo "<th> <input type='checkbox' name='role' value='$emp[rolesFID]'></th>";
                    ?>

                    <td><?php echo $emp['branchName']; ?></td>
                    <td><?php echo $emp['firstName']; ?></td>
                    <td><?php echo $emp['lastName']; ?></td>
                </tr>
            <?php } ?>
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
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
