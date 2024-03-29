<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Lieferant anlegen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">

        <?php

        function generateStrongPassword($length = 10, $add_dashes = false, $available_sets = 'luds')
        {
            $sets = array();
            if (strpos($available_sets, 'l') !== false)
                $sets[] = 'abcdefghjkmnpqrstuvwxyz';
            if (strpos($available_sets, 'u') !== false)
                $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
            if (strpos($available_sets, 'd') !== false)
                $sets[] = '0123456789';
            if (strpos($available_sets, 's') !== false)
                $sets[] = '!@#$%&*?';
            $all = '';
            $password = '';
            foreach ($sets as $set) {
                $password .= $set[array_rand(str_split($set))];
                $all .= $set;
            }
            $all = str_split($all);
            for ($i = 0; $i < $length - count($sets); $i++)
                $password .= $all[array_rand($all)];
            $password = str_shuffle($password);
            if (!$add_dashes)
                return $password;
            $dash_len = floor(sqrt($length));
            $dash_str = '';
            while (strlen($password) > $dash_len) {
                $dash_str .= substr($password, 0, $dash_len) . '_';
                $password = substr($password, $dash_len);
            }
            $dash_str .= $password;
            return $dash_str;
        }

        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <h4>Firma</h4>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="branchName">Firmenname *</label>
                                <input type="text" id="branchName" class="form-control" name="branchName" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sectorCode">Sector Code *</label>
                                <input type="text" class="form-control" name="sectorCode" id="sectorCode" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street">Strasse *</label>
                        <input type="text" class="form-control" name="street" id="street" required>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="houseNumber">Hausnummer *</label>
                                <input type="text" class="form-control" name="houseNumber" id="houseNumber" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="stairs">Stiege</label>
                                <input type="text" class="form-control" name="stairs" id="stairs">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="door">Türnummer</label>
                                <input type="text" class="form-control" name="door" id="door">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="postCode">Postleitzahl *</label>
                                <input type="text" class="form-control" name="postCode" id="postCode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Stadt *</label>
                                <input type="text" class="form-control" name="city" id="city" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Land *</label>
                                <input type="text" class="form-control" name="country" id="country" required>
                            </div>
                        </div>
                    </div>
                    <span style="color: indianred">* Pflichtfeld</span>
                </div>
                <div class="col-md-6">
                    <h4>Ansprechpartner</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">Vorname *</label>
                                <input type="text" class="form-control" name="firstName" id="firstName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">Nachname *</label>
                                <input type="text" class="form-control" name="lastName" id="lastName" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail *</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telNr">Festnetz</label>
                        <input type="text" class="form-control" name="telNr" id="telNr">
                    </div>
                    <div class="form-group">
                        <label for="mobilNr">Mobil *</label>
                        <input type="text" class="form-control" name="mobilNr" id="mobilNr" required>
                    </div>
                    <div class="form-group form-button-wrap">
                        <button type="submit" class="form-button btn btn-primary " name="submit">
                            <i class="fas fa-save"></i> Speichern
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php


$password = generateStrongPassword();
$ams="0";
$options = [
    'cost' => 12,
];

if (isset($_POST['submit'])) {

    $userRole = 6;
    htmlspecialchars($branchName = $_POST['branchName']);
    htmlspecialchars($street = $_POST['street']);
    htmlspecialchars($houseNumber = $_POST['houseNumber']);
    htmlspecialchars($stairs = $_POST['stairs']);
    htmlspecialchars($door = $_POST['door']);
    htmlspecialchars($postCode = $_POST['postCode']);
    htmlspecialchars($city = $_POST['city']);
    htmlspecialchars($country = $_POST['country']);
    htmlspecialchars($firstName = $_POST['firstName']);
    htmlspecialchars($lastName = $_POST['lastName']);
    htmlspecialchars($email = $_POST['email']);
    htmlspecialchars($telNr = $_POST['telNr']);
    htmlspecialchars($mobilNr = $_POST['mobilNr']);
    htmlspecialchars($sectorCode = $_POST['sectorCode']);

    //generate Password


    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    $ok = true;

    $sql = "SELECT * FROM user WHERE email=:email";
    $stmt = connectDB()->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $row = $stmt->fetch();
    //Wenn etwas gefunden wurde


    //if ($row !== false) {

        //$ok = false;
        //$bericht = "Email existiert bereits!<br>";

    //} else {
        //if ($ok == true) {

            $sql = "INSERT INTO user (
                  firstName,
                  lastName,
                  email,
                  password,
                  telNr,
                  mobilNr,
                  rolesFID,
                  branchName,
                  street,
                  houseNumber,
                  stairs,
                  door,
                  postCode,
                  city,
                  country,
                  sectorCode,
                  amsYesNo)
                  VALUES (
                          :firstName,
                          :lastName,
                          :email,
                          :password,
                          :telNr,
                          :mobilNr,
                          :rolesFID,
                          :branchName,
                          :street,
                          :houseNumber,
                          :stairs,
                          :door,
                          :postCode,
                          :city,
                          :country,
                          :sectorCode,
                          :amsYesNo)";


            $stmt = connectDB()->prepare($sql);

            $stmt->bindParam(":firstName", $firstName);
            $stmt->bindParam(":lastName", $lastName);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hash);
            $stmt->bindParam(":telNr", $telNr);
            $stmt->bindParam(":mobilNr", $mobilNr);
            $stmt->bindParam(":rolesFID", $userRole);
            $stmt->bindParam(":branchName", $branchName);
            $stmt->bindParam(":street", $street);
            $stmt->bindParam(":houseNumber", $houseNumber);
            $stmt->bindParam(":stairs", $stairs);
            $stmt->bindParam(":door", $door);
            $stmt->bindParam(":postCode", $postCode);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":country", $country);
            $stmt->bindParam(":sectorCode", $sectorCode);
            $stmt->bindParam(":amsYesNo", $ams);

            $stmt->execute();


            $msg = "<p>Sehr geehrte(r) $firstName $lastName,
                    <br> 
                    
                    <br>
                    Wir laden sie mit dieser Email herzlich zu unserem Beschaffungsportal ein. 
                    <br> In Kürze erhalten sie eine Einladung zu einer Ausschreibung. <br>Über das Portal können sie dann Angebote zu allen Ausschreibungen an denen sie teilnehmen abgeben.<br><br>
                    Ihre Zugangsdaten lauten:<br><br>
                     
                    <code>
                    Email:               $email<br>
                    Passwort:            $password<br>
                    </code>
<br>
                    <a href='http://ams.vemapacademy.com/'>Zum Login</a><br><br>
                    
                    
                    Mit freundlichen Grüßen,
                    <br>
                    Beschaffungsportal AMS</p>";

            //$msg = wordwrap($msg,90);

            $headers = "From: beschaffungsportal@ams.at \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mb_send_mail("$firstName $lastName <$email>", "Einladung zum Beschaffungsportal des Arbeitsmarktservice", $msg, $headers); /*; Content-Type: text/html; charset=ISO-8859-1*/

            echo "<div class='alert alert-success'><p>Lieferant erfolgreich eingeladen.</p></div>"; //https://getbootstrap.com/docs/4.0/components/alerts/ mit alert success
        //}

    //}
}
?>




<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
