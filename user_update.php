<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = true;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 0;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "User Update";
include "snippets/header.php";
include "snippets/top.php";
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="userName">User:
                <input type="text" name="userName" id="userName">
            </label>
            <br>
            <label for="userRole">Role:
                <select name="userRole">
                    <?php
                    // SQL Statement userRole SELECT
                    /*while(true) {
                        echo "<option>$i</option>";
                    }*/
                    ?>
                </select>
            </label>
            <br>
            <label for="userRights">Rights:
                <select name="userRights">
                    <?php
                    // SQL Statement userRights SELECT
                    /*while(true) {
                        echo "<option>$i</option>";
                    }*/
                    ?>
                </select>
            </label>
            <br>
            <button type="submit" name="senden">Senden</button>
        </form>
        <?php
        if( isset( $_GET["senden"] ) ) {
            //output
            echo "hallo";
            // SQL Statement LIKE userName SELECT
        }
        ?>
    </div>
</div>

<?php include "snippets/bottom.php"; ?>

