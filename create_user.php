<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Benutzer anlegen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">

        <?php

        $branchName = [
            "AMS Wien Dresdner Straße",
            "AMS Wien Esteplatz",
            "AMS Wien Hauffgasse",
            "AMS Wien Hietzinger Kai",
            "AMS Wien Huttengasse",
            "AMS Wien Johnstraße",
            "AMS Wien Jägerstraße",
            "AMS Wien Laxenburger Straße",
            "AMS Wien Redergasse",
            "AMS Wien Schloßhofer Straße",
            "AMS Wien Schönbrunner Straße",
            "AMS Wien Wagramer Straße",
            "AMS Wien Währinger Gürtel"];

        //                           password length|adds underscores |    chose sets (l = lowercase, u = uppercase, n = numbers, s = special characters
        function generateStrongPassword($length = 10, $add_dashes = false, $available_sets = 'luns')
        {
            $sets = array();
            if (strpos($available_sets, 'l') !== false)
                $sets[] = 'abcdefghjkmnpqrstuvwxyz';
            if (strpos($available_sets, 'u') !== false)
                $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
            if (strpos($available_sets, 'n') !== false)
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
                    <h4>Geschäftsstelle</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="branchName">Wählen Sie die Geschäftsstelle</label>
                            <select type="text" id="branchName" class="form-control" name="branchName">
                                <option selected disabled>Bitte Auswählen...</option>
                                <?php foreach ($branchName as $value) {
                                    echo "<option value='$value'>$value</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchName">Benutzer Rolle</label>
                                <select class="form-control" name='userRole' id='userRole' required><br>
                                    <option id="" disabled selected>Bitte Auswählen...</option>
                                    <?php
                                    $sql = "SELECT roles.objectID AS userRoleID, roles.name 
                                            FROM roles 
                                            WHERE roles.objectID BETWEEN 2 AND 5 OR objectID=12 
                                            ORDER BY userRoleID = 12 DESC, userRoleID";
                                    $stmt = connectDB()->query($sql);
                                    while ($row = $stmt->fetch()) {
                                        echo "<option value='$row[userRoleID]'>$row[name]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street">Strasse</label>
                        <input type="text" class="form-control" name="street" id="street">
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="houseNumber">Hausnummer</label>
                                <input type="text" class="form-control" name="houseNumber" id="houseNumber">
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
                                <label for="postCode">Postleitzahl</label>
                                <input type="text" class="form-control" name="postCode" id="postCode">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Stadt</label>
                                <input type="text" class="form-control" name="city" id="city">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Land</label>
                                <input type="text" class="form-control" name="country" id="country">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Ansprechpartner</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">Vorname</label>
                                <input type="text" class="form-control" name="firstName" id="firstName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">Nachname</label>
                                <input type="text" class="form-control" name="lastName" id="lastName">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="telNr">Festnetz</label>
                        <input type="text" class="form-control" name="telNr" id="telNr">
                    </div>
                    <div class="form-group">
                        <label for="mobilNr">Mobil</label>
                        <input type="text" class="form-control" name="mobilNr" id="mobilNr">
                    </div>
                    <div class="form-group form-button-wrap">
                        <input type="submit" class="form-button btn btn-primary " name="submit" value="Absenden">
                    </div>
                </div>
            </div>
        </form>
        <?php


        $password = generateStrongPassword();

        $options = [
            'cost' => 12,
        ];

        if (isset($_POST['submit'])) {

            htmlspecialchars($userRole = $_POST["userRole"]);
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
            $ok = true;

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
                    $stmt->bindParam(":rolesFID", $userRole);
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
                    echo "<div class='alert alert-info'>$password</div>";
                    echo "IN DATENBANK GESPEICHERT!";
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
