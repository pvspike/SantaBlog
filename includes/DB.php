<?php
// Connect to database
$db_host = 'localhost';
$db_name = 'spike_ch';
$db_user = 'spike_ch';
$db_pass = 'pass';


$DSN = 'mysql:host ='. $db_host.'; dbname='.$db_name.'';
$ConnectingDB = new PDO($DSN, $db_user, $db_pass);
