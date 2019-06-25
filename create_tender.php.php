<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "";
include "snippets/header.php";
include "snippets/top.php";
echo "<h6>". "Ams ID : " . $_SESSION["amsFID"] . "<h6>". "<br>";
echo "<h6>". " Supplier :  " . $_SESSION["supplierFID"] . "<h6>". "<br>";
?>

<div class="container-fluid">
   <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
   <div class="content">
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            
            Ausschreibung : <input type="text" name="tender" class="form-control" >
            <br>
            Ausschreibungs type :  <br><select name="tenderType">
            <option name="Diebstleistung" value="Diebstleistung">
              Diebstleistung
            </option>
            <option name="produkt" value="produkt">
              produkt
            </option>
 
</select>
            <br>
            Datum : <input type="date" name="begin" class="form-control" >
            <br>
            End Datum : <input type="date" name="end" class="form-control" >
            <br>
            megen : <input type="number" name="amount" class="form-control" placeholder="0,00 €" >
            <br>
            
           <div class="form-group">
               <label for="description">Anmerkungen (optional) :</label>
               <textarea  name="description" class="form-control" placeholder="Hier bei Bedarf Anmerkungen eintragen..." rows="4"  data-error="Please, leave us a message."></textarea>

           </div>
            <br>
            <button type="submit" class="btn btn-primary" name="absenden" > abschicken</button>
            <button  type="reset" class="btn btn-danger"  >Reset</button>
        </form>
   </div>
</div>

<?php
if( isset($_POST["absenden"]) ){
            $tender=$_POST["tender"];
            $tenderType=$_POST["tenderType"];
            $begin=$_POST["begin"];
            $end=$_POST["end"];
            $amount=(int)$_POST["amount"];
            $description=$_POST["description"];

             $sql="INSERT INTO tenders
                (tender,tenderType,begin,end,description,amount)
                VALUES
                (:tender,:tenderType,:begin,:end,:description,:amount)";

                $stmt=$db->prepare($sql);
                $stmt->bindparam(":tender",$tender);
                $stmt->bindparam(":tenderType",$tenderType);
                $stmt->bindparam(":begin",$begin);
                $stmt->bindparam(":end",$end);
                $stmt->bindparam(":amount",$amount);
                $stmt->bindparam(":description",$description);
                $stmt->execute();

}





 include "snippets/bottom.php"; ?>