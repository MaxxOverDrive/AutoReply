<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include('functions.php');

$conn = NEW MySQLi("host", "user", "password", "db");

$filter_array = array();

$sql = $conn->query("SELECT * FROM user_info");

if(mysqli_num_rows($sql) > 0) {
  while($row = mysqli_fetch_assoc($sql)) {
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $city = $row['city'];
    $max_rent = $row['max_rent'];
    $num_rooms = $row['num_rooms'];
    $num_bathrooms = $row['num_bathrooms'];
    $pets = $row['pets'];

    //CHECKING IF FILTERS EXIST TO APPEND TO THE URL
    if($max_rent > 0) {
      array_push($filter_array, 'max_price='.$max_rent);
    }
    if($num_rooms > 0) {
      array_push($filter_array, 'min_bedrooms='.$num_rooms);
    }

    //COUNTING FILTERS TO APPEND & OR NOT
    if(COUNT($filter_array) > 0) {
      $url_main = 'https://'.$city.'.craigslist.org/search/apa?';
      if(COUNT($filter_array) > 1) {
        $filter_string = implode('', $filter_array);
        $url = $url_main.$filter_string;
        getReplyToAddress($url);
      }
      else {
        $url = $url_main.$filter_array[$i];
        getReplyToAddress($url);
      }
    }
    //NO FILTERS. SEARCH ALL APARTMENTS
    else {
      $url = 'https://'.$city.'.craigslist.org/d/apts-housing-for-rent/search/apa';
      getReplyToAddress($url);
    }


  }
}

mysqli_close($conn);
?>
