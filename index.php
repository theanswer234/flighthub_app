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
            <form name="searchForm" id="searchForm" action="/app/results.php">
                <table width="100%">
                <tr>
                    <td>    
                        <label for="from">From <select name="dport">
                        <option value=""></option>
                    <?php 
                    $airports =  get_airports();
                   
                    foreach($airports as $single_airport){
                        echo '<option value="'.$single_airport['code'].'">'.$single_airport['city'].', '.$single_airport['region_code'].', '.$single_airport['country_code'].' - '.$single_airport['name'].' ('.$single_airport['code'].')</option>';
                    }
                    ?>
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="to">To <select name="aport">
                            <option value=""></option>
                    <?php 
                   
                    foreach($airports as $single_airport){
                        echo '<option value="'.$single_airport['code'].'">'.$single_airport['city'].', '.$single_airport['region_code'].', '.$single_airport['country_code'].' - '.$single_airport['name'].' ('.$single_airport['code'].')</option>';
                    }
                    ?>
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="oneway">One way <input type="checkbox" name="oneway" value="1"/></label>
                    </td>
                <tr>
                    <td>
                        <label for="departure">Departure date <input type="date" name="ddate"/></label>
                    </td>
                    <td>
                        <label for="return">Return date <input type="date" name="rdate"/></label>
                    </td>
                </tr>
                <tr>
                    
                    <td>    
                        <label for="airline_filter">Filter results by selected airlines <input type="checkbox" id="airline_filter" name="airline_filter"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul class="airline_filter_list">
                    <?php $airlines =  get_airlines();
                    foreach($airlines as $single_airline){
                        echo '<li><label for="'.$single_airline['code'].'">'.$single_airline['name'].'<input type="checkbox" name="airline_pref" value="'.$single_airline['code'].'"></label></li>';
                    }?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>     
                        <input type="submit" id="searchFormSubmit" value="Find Flights"/>
                    </td>
                </tr>
            </table>
            </form>
            
        </div>
    </body>
</html>
