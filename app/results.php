<?php

include('functions.php'); ?>
<!doctype html>
<html lang="en">
    <head>
        <title>Flight Hub App</title>
        <link type="text/css" rel="stylesheet" href="/css/style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="header">
            <h1>Flight Search</h1>
        </div>
        <div id="results">
    <?php
if(isset($_GET['dport']) && isset($_GET['aport'])){
    $dport =  $_GET['dport'];
    $aport = $_GET['aport'];
    $ddate = $_GET['ddate'];
    $rdate = $_GET['rdate'];
    $flightsout;
    $returnflights;
    $airlines = array();
    if(isset($_GET['airline_pref'])){
        $airlines = json_decode($_POST['airline_pref'], true);    
    }
    $flightsout = get_direct_flights($dport, $aport, $airlines);
    if($_GET['oneway'] == false){
        $returnflights = get_direct_flights($aport, $dport, $airlines);
    }
    $flights = array('ddate' =>$ddate,'rdate'=> $rdate, 'flightsout' => $flightsout,'returnflights'=> $returnflights);
    
    //print_r($flights);
    for($x = 0;$x < count($flights['flightsout']);$x++){

        echo '<table width="100%"><tr class="flightout" ><td>'.$flights['flightsout'][$x]['airline'].'<br/>Flight '.$flights['flightsout'][$x]['number'].'</td>';
        echo '<td>'.pretty_time($flights['ddate'].' '.$flights['flightsout'][$x]['departure_time']).'</td>';
        echo '<td>From : '.$flights['flightsout'][$x]['departure_airport'].'</td>';
        echo '<td>'.time_shift($flights['flightsout'][$x]['departure_tz'], $flights['flightsout'][$x]['arrival_tz'], $flights['ddate'].' '.$flights['flightsout'][$x]['arrival_time']).'</td>';
        echo '<td>To : '.$flights['flightsout'][$x]['arrival_airport'].'</td><td>Price : '.$flights['flightsout'][$x]['price'].'$</td></tr>';
        if($_GET['oneway'] == true){
            echo '</table>';
        }else{
            echo '<tr class="returnflight" ><td>'.$flights['returnflights'][$x]['airline'].'<br/>Flight '.$flights['returnflights'][$x]['number'].'</td>';
            echo '<td>'.pretty_time($flights['adate'].' '.$flights['returnflights'][$x]['departure_time']).'</td>';
            echo '<td>From : '.$flights['returnflights'][$x]['departure_airport'].'</td>';
            echo '<td>'.time_shift($flights['returnflights'][$x]['departure_tz'], $flights['returnflights'][$x]['arrival_tz'], $flights['ddate'].' '.$flights['returnflights'][$x]['arrival_time']).'</td>';
            echo '<td>To : '.$flights['returnflights'][$x]['arrival_airport'].'</td><td>Price : '.$flights['returnflights'][$x]['price'].'$</td></tr>';
        }
    }
}else{
    return;
}
?>
</div>
</body>
</html>
