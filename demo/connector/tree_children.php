<?php
  

      function getimage($devtype)
      {
            $img="";
            switch($devtype)
            {
                  case 2: $img="home.gif"; break;
                  case 3: $img="c-station.gif"; break;
                  case 6: $img="pv_panel.gif"; break;
                  case 7: $img="car-Icon.gif"; break;
                  case 10: $img="battery.gif"; break;
                  case 11: $img="fleet.png"; break;
                  case 12: $img="epanel.png"; break;
                  default: $img="spina.gif";

            };
            return $img;
      }

   include("../config.php");
   session_start();
   //$db =new SQLite3($data['config']['simdir']."/xml");
   $db =new SQLite3($confdir."/rdata.sqlite");
   $query="select  a.class as id, static_nodes.id as typeid, static_nodes.type as name from static_nodes, static_tree as a
   where a.class=static_nodes.class and a.parentid= (select class from static_nodes where id =".$_GET["nodetype"].")";


   $res = $db->query($query);



$childrens = "";
echo '{"entities":[';
while ($row = $res->fetchArray()) {
   
      echo $childrens.'{"id": "entity_'.$row["id"].'_'.$row["typeid"].'", "text": "'.$row["name"].'", "img": "'.getImage($row['typeid']).'"}';
      $childrens=",";
}
echo '], "events":[';

$query="select id,  name from event_type where nodetype = (select class from static_nodes where id=".$_GET["nodetype"].")";


$res = $db->query($query);



$childrens = "";
while ($row = $res->fetchArray()) {

   echo $childrens.'{"id": "event_'.$row["id"].'", "text": "'.$row["name"].'", "img": "schedule.gif"}';
   $childrens=",";
}

echo ']}';

?>
