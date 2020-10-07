<?php
   /*
	require_once("../config.php");
	$res=mysql_connect($mysql_server,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db);
  */
   require("../../codebase/db_sqlite3.php");

   $db =new SQLite3('/home/salvatore/git/GCSimulator/provaSim/xml/prova.sqlite');
 
   require("../../codebase/tree_connector.php");
   $tree = new TreeConnector($db,"SQlite3");

function custom_format($item){

   switch ($item->get_value("type")) {
      case 1:
         $item->set_image("smart-city.gif");
          break;
      case 2:
         $item->set_image("home.gif");
          break;
      case 3:
            $item->set_image("c-station.gif");
            break;
      case 5:
          $item->set_image("spina.gif");
          break;
      case 7:
         $item->set_image("car-Icon.gif");
          break;
         /*
      default:
         echo "i is not equal to 0, 1 or 2";*/
  }
}


$tree->event->attach("beforeRender",custom_format);
//   
   $tree->render_table("static","nodeid","name,type","","parentid");
?>