<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "UploadCSV"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <?php
            function readCSV($filename = "test.csv")
            {
                $file = file("temp/$filename");
                $sql = "INSERT INTO tenderDetail(
                                             tendersFID,
                                             position,
                                             `longtext`,
                                             amount)
                    VALUES (
                            :tendersFID,
                            :position,
                            :langtext,
                            :amount)";
                foreach ($file as $output) {
                    $dismantle = explode(";", $output);
                    if (!in_array("tendersFID", $dismantle)) {
                        if (!in_array("tendersFID", $dismantle)) $tendersFID = $dismantle[0];
                        if (!in_array("position", $dismantle)) $position = $dismantle[1];
                        if (!in_array("langtext", $dismantle)) $amount = $dismantle[3];
                        if (!in_array("amount", $dismantle)) $longtext = $dismantle[2];

                        $stmt = connectDB()->prepare($sql);
                        $stmt->bindParam(":tendersFID", $tendersFID);
                        $stmt->bindParam(":position", $position);
                        $stmt->bindParam(":longtext", $longtext);
                        $stmt->bindParam(":amount", $amount);
                        $stmt->execute();
                    }
                }
            }


            ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
