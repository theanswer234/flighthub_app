<?php


function get_airports($codes = array()){
    include('db.php');
    $airports = array();
    $code_query = '';
    if(count($codes) > 0){
        $code_query = ' where code in ("'.implode('", "', $codes).'")';
    }
    $query = 'select city, region_code, country_code, name, code from airports'.$code_query;
    $fetch = $mysqli->query($query);

    while($row = $fetch->fetch_assoc()){
        array_push($airports, $row);
    }
    $mysqli->close();
    return $airports;
}

function get_airlines($codes = array()){
    include('db.php');
    $airlines = array();
    $airline_query = '';
    if(count($codes) > 0){
        $airline_query = ' where code in ("'.implode('", "', $codes).'")';
    }
    $query = 'select code, name from airlines'.$airline_query;
    $fetch = $mysqli->query($query);

    while($row = $fetch->fetch_assoc()){
        array_push($airlines, $row);
    }
    $mysqli->close();
    return $airlines;
}

function get_direct_flights($dport, $aport, $airlines = array()){
    include('db.php');
    $flights = array(); 
    $airline_query = '';
    if(count($airlines) > 0){
        $airline_query = ' and airline in ("'.implode('", "', $airlines ).'")';
    }
    $query = 'select airline, number, departure_airport, departure_time, arrival_airport, arrival_time, price from flights where departure_airport = "'.$dport.'" and arrival_airport = "'.$aport.'"'.$airline_query;
    $fetch = $mysqli->query($query);

    while($row = $fetch->fetch_assoc()){
        $airline = get_airlines(array($row['airline']));
        $depart = get_airports(array($dport));
        $arrival = get_airports(array($aport));
        $flight = array(
            'airline' => $airline['name'], 
            'number' => $row['number'], 
            'departure_airport' => $depart['city'].', '.$depart['region_code'].', '.$depart['name'].' ('.$depart['code'].')', 
            'departure_time' => $row['departure_time'], 
            'arrival_airport' => $arrival['city'].', '.$arrival['region_code'].', '.$arrival['name'].' ('.$arrival['code'].')', 
            'arrival_time' => $row['arrival_time'],
            'price' => $row['price']
        );
        array_push($flights, $flight);
    }
    $mysqli->close();
    return $flights;
}