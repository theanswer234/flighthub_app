<?php


function get_airports($codes = array()){
    include('db.php');
    $airports = array();
    $code_query = '';
    if(count($codes) > 0){
        $code_query = ' where code in ("'.implode('", "', $codes).'")';
    }
    $query = 'select city, region_code, country_code, name, code, timezone from airports'.$code_query;
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
            'airline' => $airline[0]['name'], 
            'number' => $row['number'], 
            'departure_airport' => $depart[0]['city'].', '.$depart[0]['region_code'].', '.$depart[0]['name'].' ('.$depart[0]['code'].')', 
            'departure_tz' => $depart[0]['timezone'],
            'departure_time' => $row['departure_time'], 
            'arrival_airport' => $arrival[0]['city'].', '.$arrival[0]['region_code'].', '.$arrival[0]['name'].' ('.$arrival[0]['code'].')', 
            'arrival_tz'=> $arrival[0]['timezone'],
            'arrival_time' => $row['arrival_time'],
            'price' => $row['price']
        );
        array_push($flights, $flight);
    }
    $mysqli->close();
    return $flights;
}
function pretty_time($datetime){
    $date = new DateTime($datetime);
    return $date->format('D j M Y H:i');
}
function time_shift($tzA, $tzB, $date){
    date_default_timezone_set($tzA);
    $dateA = new DateTime($date);
    $newtimezone = new DateTimeZone($tzB);
    $dateA->setTimezone($newtimezone);
    return $dateA->format('D j M Y H:i');
}