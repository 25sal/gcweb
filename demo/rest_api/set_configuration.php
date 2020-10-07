<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ../index.php");
    exit;
}
  //get conf name and eventually old conf
  $simid= $_GET["conf"];
  include("../config.php");

 
  //return conf id
  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");

  $db =new SQLite3($confdir."/rdata.sqlite");
  $query = 'SELECT  name FROM configurations where id='.intval($simid);
  $res = $db->query($query);
   if ($row = $res->fetchArray())
    {
    
    $data['config']['simulation']= $row['name'];
    yaml_emit_file($_SESSION["workingdir"]."/config.yml",$data);
   echo 1;
    }
    echo 0;


?>