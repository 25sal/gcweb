<?php
	require_once("../config.php");
	$res=mysqli_connect($mysql_server,$mysql_user,$mysql_pass);
	mysqli_select_db($mysql_db);

   require("../../codebase/tree_connector.php");
   $tree = new TreeConnector($res);
//   
   $tree->render_table("tasks","taskId","taskName","","parentId");
?>
