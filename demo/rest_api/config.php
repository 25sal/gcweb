<?php 
   session_start();
   $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");

   
   $data['config']['protocol'] = $_POST['protocol']; 
   yaml_emit_file($_SESSION["workingdir"]."/config.yml",$data);


  ?>