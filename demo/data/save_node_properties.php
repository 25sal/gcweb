<?php
include("../config.php");
session_start();
$data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  
$db = new SQLite3($data['config']['simulation_dir']."/".$data['config']['simulation']."/db.sqlite");
       
foreach($_POST as $key => $value) {
    $query = 'INSERT INTO staticParameter VALUES(NULL,'.$_GET['nodeid'].',"'.$key.'","'.$value.'");';
    //echo $query;
    $res = $db->exec($query);
  }
  echo 1;

?>

