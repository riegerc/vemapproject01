<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Lieferant anlegen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <?php

        function generateStrongPassword($length = 10, $add_dashes = true, $available_sets = 'luds')
        {
            $sets = array();
            if (strpos($available_sets, 'l') !== false)
                $sets[] = 'abcdefghjkmnpqrstuvwxyz';
            if (strpos($available_sets, 'u') !== false)
                $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
            if (strpos($available_sets, 'd') !== false)
                $sets[] = '23456789';
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
            <label>Firma: </label>
            <input type="text" class="form-control" name="branchName"
                   placeholder="Firmenname..."><br>

            <label>Adressedaten: </label>
            <input type="text" class="form-control" name="street"
                   placeholder="Straße..."><br>
            <input type="text" class="form-control" name="houseNumber"
                   placeholder="Hausnummer..."><br>
            <input type="text" class="form-control" name="stairs"
                   placeholder="Stiege..."><br>
            <input type="text" class="form-control" name="door"
                   placeholder="Tür..."><br>
            <input type="text" class="form-control" name="postCode"
                   placeholder="PLZ..."><br>
            <input type="text" class="form-control" name="city"
                   placeholder="Stadt.."><br>
            <input type="text" class="form-control" name="country"
                   placeholder="Land..."><br>

            <label>Ansprechpartner: </label>
            <input type="text" class="form-control" name="firstName"
                   placeholder="Vorname..."><br>
            <input type="text" class="form-control" name="lastName"
                   placeholder="Nachname..."><br>
            <input type="text" class="form-control" name="email"
                   placeholder="E-Mail..."><br>
            <input type="text" class="form-control" name="telNr"
                   placeholder="Festnetz..."><br>
            <input type="text" class="form-control" name="mobilNr"
                   placeholder="Mobil..."><br>

            <input type="submit" class="btn btn-primary" name="submit" value="Absenden"><br>
        </form>


        <?php


        $password = generateStrongPassword();

        $options = [
            'cost' => 12,
        ];

        if (isset($_POST['submit'])) {

            $roles = 10;
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

            //generate Password


            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
            $ok=true;

            $sql = "SELECT * FROM user WHERE email=:email";
            $stmt = connectDB()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $row = $stmt->fetch();
            //Wenn etwas gefunden wurde




            if ($row !== false) {

                $ok = false;
                $bericht = "Email existiert bereits!<br>";

            } else {
                if ($ok == true) {

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
                  sectorCode)
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
                          :sectorCode)";


                    $stmt = connectDB()->prepare($sql);

                    $stmt->bindParam(":firstName", $firstName);
                    $stmt->bindParam(":lastName", $lastName);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $hash);
                    $stmt->bindParam(":telNr", $telNr);
                    $stmt->bindParam(":mobilNr", $mobilNr);
                    $stmt->bindParam(":rolesFID", $roles);
                    $stmt->bindParam(":branchName", $branchName);
                    $stmt->bindParam(":street", $street);
                    $stmt->bindParam(":houseNumber", $houseNumber);
                    $stmt->bindParam(":stairs", $stairs);
                    $stmt->bindParam(":door", $door);
                    $stmt->bindParam(":postCode", $postCode);
                    $stmt->bindParam(":city", $city);
                    $stmt->bindParam(":country", $country);
                    $stmt->bindParam(":sectorCode", $country);

                 $stmt->execute();
                 echo $password;
//                    // echo "IN DATENBANK GESPEICHER!";
//
//
//
//                    $msg = "Sehr geehrte(r) $firstName $lastName \n
//                     Diese Email enthält Ihre Zugangsdaten zu unserem Auftragsportal.\n
//                     Zugangsdaten:\n
//                     Email:               $email\n
//                     Passwort:            $password\n";
//                    $msg = wordwrap($msg,70);
//                    mail($email,
//                        "Ihre Zugangsdaten zu unserem Portal",
//                        $msg);
                }

            }
        }
        ?>


    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
