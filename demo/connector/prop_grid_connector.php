<?php
	 
	   include("../config.php");
       session_start();



     $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
     $sim_dir = $data['config']['simulation_dir']."/".$data['config']['simulation'];
     
	 require("./codebase/db_sqlite3.php");
	 require("./codebase/grid_connector.php");
	 $db =new SQLite3($sim_dir."/db.sqlite");
	
	$grid = new GridConnector($db,"SQLite3");
	$par_id=0;
	if(isset($_POST["ids"]))	
		$par_id=$_POST["ids"];
	
		if(isset($_GET["editing"])){
		$query= "update  staticParameter set val='{val}' where id='{id}'";
		$grid->sql->attach("editing",$query);
		}
	$grid->render_sql("SELECT id,key,val from staticParameter where id =".$par_id,"id","key,val");

?>
