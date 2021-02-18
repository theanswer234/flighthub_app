<?php include('app/functions.php'); ?>
<!doctype html>
<html lang="en">
    <head>
        <title>Flight Hub App</title>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="header">
            <h1>Flight Search</h1>
        </div>
        <div id="searchFormWrap">
            <form name="searchForm" id="searchForm">
                <label for="from">From <select name="from">
                    <option value=""></option>
                    <?php 
                    $airports =  get_airports();
                   
                    foreach($airports as $single_airport){
                        echo '<option value="'.$single_airport['code'].'">'.$single_airport['city'].', '.$single_airport['region_code'].', '.$single_airport['country_code'].' - '.$single_airport['name'].' ('.$single_airport['code'].')</option>';
                    }
                    ?>
                    </select>
                </label>
                <label for="to">To <select name="to">
                    <option value=""></option>
                    <?php 
                   
                    foreach($airports as $single_airport){
                        echo '<option value="'.$single_airport['code'].'">'.$single_airport['city'].', '.$single_airport['region_code'].', '.$single_airport['country_code'].' - '.$single_airport['name'].' ('.$single_airport['code'].')</option>';
                    }
                    ?>
                    </select>
                </label>
                <label for="departure">Departure date <input type="date" name="departure_date"/></label>
                <label for="return">Return date <input type="date" name="return_date"/></label>
                <button id="searchFormSubmit">Find Flights</button>
            </form>

        </div>
    </body>
</html>
