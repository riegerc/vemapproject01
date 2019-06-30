<?php
/*
	Autoren: Lubomir Mitana, Christian Riedler
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once("classes/repository.inc.php");
require_once("classes/types/bewertung.inc.php");
$rep=new Repository();
$bewertungen=$rep->readBewertungen();
/*
echo "<pre>";
print_r($bewertungen);
echo "</pre>";
*/
$labels=array();
foreach($bewertungen as $bewertung){
	if(!in_array( $bewertung->getCriteriaName(),$labels)){
		array_push($labels, $bewertung->getCriteriaName());
	}
}
	echo "<pre>";
print_r($bewertungen);
echo "</pre>";

?>
<link rel="stylesheet" type="text/css" href="css/reviews.css" media="all" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <canvas id="mainCanvas"></canvas>
		
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
<script>
            // Grab canvas
            var ctx = document.getElementById('mainCanvas').getContext('2d');

            var chart = new Chart(ctx, {
            // The type of chart
            type: 'line',
            // The data for dataset
            data: {
                labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli'],
                datasets: [
					<?php 
					$ausgabe="";
						foreach($labels as $label){
							$ausgabe.="{";
							 $ausgabe.= "label: '".$label."',";
							 $ausgabe.= "data:[";
							
							 foreach($bewertungen as $bewertung){
								if($bewertung->getCriteriaName() == $label){
									$ausgabe.= round($bewertung->getAvg()).",";
								}
							 }
							 
							//$ausgabe.="data:[75,85,71,92,72,72,70,92,80,76,73,88,80,70,71,87,83,100],";
							 $ausgabe.= "],";
							$ausgabe.= "},";
						}
						echo $ausgabe;
					?>
					/*
                    label: 'Einkauf',
                    backgroundColor: '#e56bcd',
                    borderColor: '#e56bcd',
                    lineTension: 0,
                    data: [30, 50, 60, 65, 50, 30, 45],
                    fill: false,
                    },
                    {
                    label: 'Logistik',
                    backgroundColor: '#579dbc',
                    borderColor: '#579dbc',
                    lineTension: 0,
                    data: [50, 45, 30, 60, 50, 20, 30],
                    fill: false,
                    },
                    {
                    label: 'Qualität',
                    backgroundColor: '#e0a02e',
                    borderColor: '#e0a02e',
                    lineTension: 0,
                    data: [40, 40, 35, 40, 50, 35, 50],
                    fill: false,
                    },
                    {
                    label: 'Technologie',
                    backgroundColor: '#88ac00',
                    borderColor: '#88ac00',
                    lineTension: 0,
                    data: [45, 25, 35, 45, 55, 65, 50],
                    fill: false,
					*/
                ]
            },
            // Configuration options
            options: {            
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Chart.js Template'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 100,
                            }
                        }]                
                    }
            }
        }); // END chart
        </script>

