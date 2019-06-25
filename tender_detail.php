<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "include/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "";
include "include/page/top.php";
include_once "include/database.php";
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <a href="../PHP/project/pdf.php?id=tenders.php" >&#8636 Zurück zu ihren Ausschreibungen</a>
        <h2>Kugelschreiber für die  Standortverteidigung des AMS</h2>

        <a href="../PHP/project/pdf.php?id=7" class="float-right" ><button type="button" class="btn btn-danger"><i class="fas fa-file-download"></i> Als PDF herunterladen</button> </a>
        <br>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="row">Art des Auftrags:</th>
                <td>Produkt</td>
            </tr>

            <tr>
                <th scope="row">Auftraggeber:</th>
                <td>AMS Schloßhofer Straße</td>
            </tr>

            <tr>
                <th scope="row">Beginn:</th>
                <td>18.06.2019</td>
            </tr>

            <tr>
                <th scope="row">Ende:</th>
                <td>20.08.2019</td>
            </tr>

            <tr>
                <th scope="row">Beschreibung:</th>
                <td>Sir?

                    I know this is going to sound ridiculous... I'll be the FIRST TO ADMIT IT. I was skeptical at a certain point in my life with almost cookie cutter concerns/fears. Want to know what made a significant improvement?

                    I took a hand gun class and bought a Kugelschreiber.

                    Sounds stupid right? I said so too. But sure enough, I started hitting the range like a lot of guys go to the gym or jog/run. Now I have a completely different perspective on life.

                    I can't say it is solely because I am proficient with my Kugelschreiber. I WILL SAY that it has contributed to the new perspective immensely. I used to hate guns. My stepdad was an IALEFI certified instructor for decades. He used to push the weapons into my hand.

                    Once I grew up, buddy of mine says, take a class. Just take it. If you still hate it, fine. I'll pay for the class.

                    So, I did.

                    I didn't hate it. It became a familiar thing to me. And now, when I'm feeling tense, I got to the range. I spend time in there blowing off steam. I feed paper to the bullets. I even use the silhouette that looks like a mugger. And when I leave?

                    It feels good. Its a similar euphoria to sex. I've even worked out major proposal dilemmas while in the range. I've found solutions to many of life's little quirks amd even some of the big ones.

                    The wife even says I'm more "in tune" with myself.

                    Shrugs I dunno, man. If I knew you personally, I'd make the same offer my buddy made me.

                    I know you won't regret it though.</td>
            </tr>

            <tr>
                <th scope="row">Erfüllungsort:</th>
                <td> Schloßhofer Str. 16-18, 1210 Wien</td>
            </tr>

            <tr> <!-- If Dienstleistung keine Menge einzeigen -->
                <th scope="row">Menge:</th> <!-- If Dienstleistung keine Menge einzeigen -->
                <td>50 Stück</td> <!-- If Dienstleistung keine Menge einzeigen -->
            </tr> <!-- If Dienstleistung keine Menge einzeigen -->



            </thead>
        </table>

    </div>
</div>

<?php include "include/page/bottom.php"; ?>

