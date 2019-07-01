<?php
/*
	Autoren: Lubomir Mitana, Christian Riedler
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Auswertung Übersicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once("classes/repository.inc.php");
require_once("classes/types/bewertung.inc.php");
require_once("classes/types/chart.inc.php");
require_once("include/helper.inc.php");
$rep=new Repository();
if(isset($_GET["lieferantid"])){
	$lieferantid=(int)Helper::sanitize($_GET["lieferantid"]);
	$chart=$rep->readChart($lieferantid);
}else{
	$chart=$rep->readChart();
}


$labels=array();
$months=array();
$monthNames=["Jänner","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"];
foreach($chart->getBewertungen() as $bewertung){
	if(!in_array( $bewertung->getCriteriaName(),$labels)){
		array_push($labels, $bewertung->getCriteriaName());
	}
	if(!in_array( $bewertung->getMonth(),$months)){
		array_push($months, $bewertung->getMonth());
	}	
}

?>
<link rel="stylesheet" type="text/css" href="css/reviews.css" media="all" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
	<h2><?php echo $chart->getSupplierName() ?></h2>
        <canvas id="mainCanvas"></canvas>
		<a href="review_auswertung.php?lieferantid=<?=$lieferantid?>">Details</a>
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
				labels: [
					<?php
						$monthNames=["Jänner","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"];
						foreach($months as $month){
							echo "'".$monthNames[$month-1]."',";
						}
					?>
				],
                datasets: [
					<?php 
					$colors=["#e56bcd","#579dbc", "#e0a02e"];
					$ausgabe="";
						for($i=0;$i<=count($labels)-1;$i++){
							$ausgabe.="{";
							 $ausgabe.= "label: '".$labels[$i]."',";
							 $ausgabe.= "backgroundColor: '$colors[$i]',";
							 $ausgabe.= "borderColor: '$colors[$i]',";
							 $ausgabe.= "lineTension:0,";
							 $ausgabe.= "data:[";
							
							 foreach($chart->getBewertungen() as $bewertung){
								if($bewertung->getCriteriaName() == $labels[$i]){
									$ausgabe.= round($bewertung->getAvg()).",";
								}
							 }
							 
							 $ausgabe.= "],";
							 $ausgabe .= "fill: false,";
							$ausgabe.= "},";
						}
						echo $ausgabe;
					?>
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

