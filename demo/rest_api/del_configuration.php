<?php

function rmdir_recursive($directory, $delete_parent = null)
  {
    $files = glob($directory . '/{,.}[!.,!..]*',GLOB_MARK|GLOB_BRACE);
    foreach ($files as $file) {
      if (is_dir($file)) {
        rmdir_recursive($file, 1);
      } else {
        unlink($file);
      }
    }
    if ($delete_parent) {
      rmdir($directory);
    }
  }


session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ../index.php");
    exit;
}
  //get conf name and eventually old conf
  $simid= $_POST["sim_id"];
  if(intval($simid)==1) 
    echo 0;
  else {
    include("../config.php");

 
    //return conf id
    $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");

    $db =new SQLite3($confdir."/rdata.sqlite");
    $query = 'SELECT  name FROM configurations where id='.intval($simid);
    $res = $db->query($query);
    if ($row = $res->fetchArray())
    {
    
        rmdir_recursive($data['config']['simulation_dir']."/".$row["name"]);
       
        $data['config']['simulation']= 'demo';
        yaml_emit_file($_SESSION["workingdir"]."/config.yml",$data);
        $query = 'DELETE FROM configurations where id='.intval($simid);
        $res = $db->query($query);
        echo 1;
    }
    else
     echo 0;
    }

?>