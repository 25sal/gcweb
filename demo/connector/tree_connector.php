<?php
  
   require("./codebase/db_sqlite3.php");
   include("../config.php");
   session_start();



  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  $sim_dir = $data['config']['simulation_dir']."/".$_GET['simdir'];
   //$db =new SQLite3($data['config']['simdir']."/xml");
   $db =new SQLite3($sim_dir."/db.sqlite");
   require("./codebase/tree_connector.php");
   $tree = new TreeConnector($db,"SQlite3");

function custom_format($item){

   $item->set_userdata("type",$item->get_value("type"));
   $sel_item = $item->get_value("type");
   if($sel_item > 100)
         $sel_item = 100;
   switch ($sel_item) {
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
      case 6:
           $item->set_image("pv_panel.gif");
         break;
      case 7:
         $item->set_image("car-Icon.gif");
          break;
      case 100:
         $item->set_image("schedule.gif");
          break;
         /*
      default:
         echo "i is not equal to 0, 1 or 2";*/
  }
}


$tree->event->attach("beforeRender",'custom_format');
//   
   $tree->render_table("static","nodeid","name,type","","parentid");


?>

