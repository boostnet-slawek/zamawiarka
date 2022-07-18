<?php
$link = mysqli_connect("localhost", "sql_crm_boostnet", "BksTx6mwxsaYhELK", "sql_crm_boostnet");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
   
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
  
  ?>