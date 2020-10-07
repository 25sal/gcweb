<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ../index.php");
    exit;
}
  //get conf name and eventually old conf
  $new_simname= $_POST["newsim"];
  include("../config.php");

 
  //return conf id
  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  $sim_path = dirname($data['config']['simulation_dir']);

  $new_simdir = $sim_path."/Simulations/".$new_simname;
  //echo $new_simdir;
  if(!file_exists($new_simdir))
  {
  
    mkdir($new_simdir, 0755,true);
    if($_POST["action"]=="newconf")
        copy($confdir."/db.sqlite",$new_simdir."/db.sqlite");
    else if($_POST["action"]=="saveas")
        copy($sim_path."/Simulations/".$_POST["template"]."/db.sqlite", $new_simdir."/db.sqlite");

    $data['config']['simulation']= $new_simname;
    yaml_emit_file($_SESSION["workingdir"]."/config.yml",$data);
    $db =new SQLite3($confdir."/rdata.sqlite");
    $query = 'INSERT INTO configurations VALUES(NULL,"'.$new_simname.'")';
    $res = $db->query($query);
    
    if ($res) { $result = $db->lastInsertRowid(); echo $result;}
    else return 0;
  }
  else 
      echo -1;


?>