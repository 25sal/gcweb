<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ../index.php");
    exit;
}
  include("../config.php");

 
  $db =new SQLite3($confdir."/rdata.sqlite");
  $query = 'SELECT id, name FROM configurations';
  $res = $db->query($query);
  echo '[';
  $coma="";

  while ($row = $res->fetchArray())
    {
     echo $coma.' {"id":'.$row['id'].',"name":"'.$row['name'].'"}';
     $coma=',';
 
    }
    echo "]";

?>