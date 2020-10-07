<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ../index.php");
    exit;
}
  //get conf name and eventually old conf
  $nodeid= $_GET["nodeid"];
  include("../config.php");

  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  $db = new SQLite3($data['config']['simulation_dir']."/".$data['config']['simulation']."/db.sqlite");

  for($i=$_POST["id_start"]; $i < $_POST["id_end"]; $i++)

    {  $query = 'INSERT INTO static (nodeid, parentid, name, type) SELECT NULL, parentid, "'.$_GET["name"].$i.']", type FROM static WHERE nodeid ='.$nodeid;
       $db->query($query);

       $query = "select seq from sqlite_sequence where name='static'";
       $results = $db->query($query);

        if($results)
        { 
            $row = $results->fetchArray();
            $query = 'INSERT INTO staticParameter (id, idDevice, key, val) SELECT NULL, '.$row['seq'].', key, val FROM staticParameter WHERE idDevice ='.$nodeid;
            error_log($query);
            $db->query($query);
        }
        
    } 

  $db->close();
  //return conf id
  
 


?>