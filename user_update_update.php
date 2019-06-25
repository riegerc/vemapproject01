<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php";
if(isset($_GET["user"])) {
    $firstName=$_GET["firstName"];
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <input type="text" name="firstName" >
            <input type="text" name="lastName" >
            <input type="text" name="role" >
            <input type="text" name="email" >
            <input type="text" name="telNr" >
            <input type="text" name="mobilNr" >
            <input type="text" name="branchName" >
            <input type="text" name="street" >
            <input type="text" name="houseNumber" >
            <input type="text" name="stairs" >
            <input type="text" name="door" >
            <input type="text" name="postCode" >
            <input type="text" name="city" >
            <input type="text" name="country" >
            <input type="text" name="sectorCode" >
            <button type="submit" name="senden">Senden</button>
        </form>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>
