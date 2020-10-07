<?php
include("../config.php");
session_start();
$data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  
$db = new SQLite3($data['config']['simulation_dir']."/".$data['config']['simulation']."/db.sqlite");
$query = "select seq from sqlite_sequence where name='static'";
$results = $db->query($query);

if($results)
 { $row = $results->fetchArray();
    echo $row['seq'];
 }
else 
 echo -1;
?>

