<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: ./index.php");
    exit;
}
$data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");

?>

<html>
<head>
<!--https://dhtmlx.com/docs/products/visualDesigner/live/#g40o46-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx/codebase/fonts/font_roboto/roboto.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx/codebase/dhtmlx.css"/>
		<link rel="stylesheet" type="text/css" href="dhtmlx/skins/skyblue/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx/skins/web/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx/skins/terrace/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="codebase/greencharge.css"/>
	<script src="dhtmlx/codebase/dhtmlx.js"></script>
	
	<link rel="stylesheet" type="text/css" href="mdn/play.css">
	
	
	
	<script language="JavaScript" type="text/javascript" src="js/simulator.js"></script>
 
	<script language="JavaScript" type="text/javascript" src="mdn/js/jquery-3.4.1.min.js"></script>
	
	
	<style>
		div#layoutObj {
			position: relative;
			margin-top: 0px;
			margin-left: 10px;
			width: 1600px;
			height: 1000px;
		}
	</style>
	

</head>
<body>
	<body onload="doOnLoad();">
	<div id="layoutObj"></div>

<script>
 var configuration_form;
 //var visualization_page = '../dashboard/dashboard.php?user='+"<?php echo basename($data['config']['workingdir']);?>"+"&workingdir="+"<?php echo $data['config']['simulation'];?>";
 var visualization_page ="vis/vis.php"
 simulator_process = "<?php echo $_SESSION["simulator"] ?>";
 var tabbar;

 function doOnLoad() {	

	window.dhx4.skin = 'dhx_web';
	var main_layout = new dhtmlXLayoutObject(document.body, '1C');

	var a = main_layout.cells('a');
	a.setText(' ');
	var sidebar = a.attachSidebar({template: 'details', width: '200', icons_path: './codebase/imgs_sidebar/', autohide: '', header: ''});
	sidebar.addItem({id: 'neighbourhood_sitem', text: 'Neighbourhood', icon: 'sidebar_item_icon.png'});
	var neighbourhood_sitem = sidebar.cells('neighbourhood_sitem');
	neighbourhood_sitem.setActive();
	var layout_2 = neighbourhood_sitem.attachLayout('2U');

	var cell_4 = layout_2.cells('a');
	cell_4.setText('Configuration');
	
	


	var cell_5 = layout_2.cells('b');
	var accordion_1 = cell_5.attachAccordion();
	var panel_1 = accordion_1.addItem('panel_1','Parameters');
	var grid_1 = panel_1.attachGrid();
	grid_1.setIconsPath('./codebase/imgs/');
	
	grid_1.setHeader(["Property","Value"]);
	grid_1.setColTypes("ro,ro");
	
	grid_1.setColSorting('str,str');
	grid_1.setInitWidths('*,*');
	grid_1.init();
	//grid_1.load('./data/static_parameters.xml', 'xml');
	grid_1.load("connector/prop_grid_connector.php");

	var dp = new dataProcessor("connector/prop_grid_connector.php");

	//VALIDAZIONE GRID

	dp.setVerificator(1,check_rule); //controlla i campi modificati
	
	function check_rule(value,id,ind){ //funzione di validazione
		switch (grid_1.cellById(id,0).getValue()) {//fisso la colonna 0 che contiene i campi
        case "id" :
			return dhtmlxValidation.isValidInteger(value)?true:'ID must be an integer';
            break;
		
		case "type" :
			return dhtmlxValidation.isValidInteger(value)?true:'type must be an integer';
            break;
		
		case "peakLoad" :
			return dhtmlxValidation.isValidInteger(value)?true:'peakLoad must be an integer';
            break;

		case "name" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'name must be a string';
            break;

		case "Location_ID" :
			return dhtmlxValidation.isValidInteger(value)?true:'Location ID must be a string';
            break;

		case "Entry_Time" :
			return dhtmlxValidation.isValidDatetime(value)?true:'Entry Time must be a valid DateTime';
            break;

		case "Exit_Time" :
			return dhtmlxValidation.isValidDatetime(value)?true:'Exit Time must be a valid DateTime';
            break;

		case "Device_model" :
			return dhtmlxValidation.isValidNumeric(value)?true:'Device_model must be a valid number';
            break;
		
		case "Peak_Power" :
			return dhtmlxValidation.isValidNumeric(value)?true:'Peak_Power must be a valid number';
            break;

		case "Battery_ID" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Battery_ID must be a valid string';
            break;

		case "Inverter_device_model" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Inverter_device_model must be a valid string';
            break;

		case "PV_Panels" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Panels must be a valid string';
            break;

		case "No" :
			return dhtmlxValidation.isValidNumeric(value)?true:'No must be a valid number';
            break;

		case "Azimuth" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Azimuth must be a valid string';
            break;

		case "Tilt" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Tilt must be a valid string';
            break;

		case "Noct" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Noct must be a valid string';
            break;

		case "Temperature_" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Temp must be a valid string';
            break;

		case "Albedo" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Albedo must be a valid string';
            break;

		case "CP_Name" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'CP_Name must be a valid string';
            break;

		case "Charging_Capacity" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Charging_Capacity must be a valid string';
            break;

		case "Comment" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Comment must be a valid string';
            break;

		case "Connector_Type" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Connector_Typee must be a valid string';
            break;

		case "capacity" :
			return dhtmlxValidation.isValidNumeric(value)?true:'capacity must be a valid number';
            break;

		case "cheff" :
			return dhtmlxValidation.isValidNumeric(value)?true:'cheff must be a valid number';
            break;

		case "dis_eff" :
			return dhtmlxValidation.isValidNumeric(value)?true:'dis_eff must be a valid number';
            break;

		case "maxallen" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'maxallen must be a valid string';
            break;

		case "maxchpowac" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxchpowac must be a valid number';
            break;

		case "maxchpowdc" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxchpowdc must be a valid number';
            break;

		case "maxdispowac" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxdispowac must be a valid number';
            break;

		case "maxdispowdc" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'maxdispowdc must be a valid number';
            break;

		case "minallen" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'minallen must be a valid string';
            break;

		case "model" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'model must be a valid string';
            break;

		case "sbch" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'sbch must be a valid string';
            break;

		case "sbdis" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'sbch must be a valid string';
            break;
		default:
		return true;
		}
		return true //ignore the validation if the checkbox is not checked
	}
	dp.attachEvent("onValidationError",function(id,messages){
				dhtmlx.alert(messages.join("<br>"));
				//return true; // confirm block
			});
			
	dp.init(grid_1);
	



/*
	var panel_2 = accordion_1.addItem('panel_2','Dynamic');
	var grid_2 = panel_2.attachGrid();
	grid_2.setIconsPath('./codebase/imgs/');
	
	grid_2.setHeader(["Column 1","Column 2"]);
	grid_2.setColTypes("ro,ro");
	
	grid_2.setColSorting('str,str');
	grid_2.setInitWidths('*,*');
	grid_2.init();
	grid_2.load('./data/dynamic_parameters.xml', 'xml');
*/	

/****BEGIN Tree ******/


/*
	var treeview_2 = cell_4.attachTreeView();
	treeview_2.loadStruct('./data/treeview.xml');

	treeview_2.attachEvent('onSelect', function(id, state){
		var nodetype=treeview_2.getUserData(id, "type");
		var devid=treeview_2.getUserData(id, "id");
		grid_1.load('./data/static_parameters.xml?devid='+id+"&devtype="+nodetype, 'xml');
		grid_2.load('./data/dynamic_parameters.xml?devid='+id+"&devtype="+nodetype, 'xml');
	});

*/
var tree;

createTreeConfig();

    //


function createTreeConfig()
 {tree = cell_4.attachTree();

tree.setImagePath("./codebase/imgs/dhxtreeview_web/");
tree.setStdImages("spina.gif","spina.gif","spina.gif");

tree.attachEvent("onXLE", function(){
  // after loading ended and data rendered (before user's callback)
  // your code here
    tree.openAllItems(0);
  });

  //tree.enableDragAndDrop(true);  //abilito drag and drop
  tree.attachEvent("onClick", function (id){
  grid_1.load('./data/static_parameters.xml?devid='+id, 'xml');
  //grid_2.load('./data/dynamic_parameters.xml?devid='+id, 'xml');
	return true;
  }); 
  tree.attachEvent("onRightClick", menu);  //collego rightclick alla funzione menu
 
  /*
        myContextMenu.attachEvent("onClick", additem);  //collego il click degli item del menu alla funzione additem
        myContextMenu.attachEvent("onClick", deleteitem);  //collego la funzione per l'eliminazione di un item selezionato
        myContextMenu.attachEvent("onClick", addproperties);
  */
var confdir = "../resources/conf"; //temporary value
tree.load("./connector/tree_config.php",setIcon,'xml');
 //tree.enableContextMenu(true); 

  dp = new dataProcessor("./connector/tree_config.php");
   
    
  dp.init(tree);
}

function setIcon() {
}


function menu(id, obj){

  $.ajax
				  ({
					 url: './connector/tree_children.php?nodetype='+tree.getUserData(tree.getSelectedItemId(),"type"),
					 type: 'get',
					 contentType: false,
					 processData: false,
					 async: true,
					 success: function(response)
						  {
			   	var entities=[];
			   	var events = [];
			   	var jsonobj = JSON.parse(response);
			   
			   	var json_ent = jsonobj.entities;
            	for (var i=0;i< json_ent.length;i++)
                  entities.push({id:json_ent[i].id, text:json_ent[i].text, img:json_ent[i].img});
                
                if(jsonobj.entities.length>0)
				  entities = {id: "entity", text: "New Entity", items: entities};
				
				var json_evt = jsonobj.events;
               	 for (var i=0;i< json_evt.length;i++)
							  {
                  events.push({id:json_evt[i].id, text:json_evt[i].text, img:json_evt[i].img});
                }
                if(jsonobj.events.length>0)
				  events = {id: "event", text: "New Event",img: "schedule.gif", items: events}

						
                    myContextMenu = new dhtmlXMenuObject({
                      icons_path: "./codebase/imgs_menu/",
                      context: true,
                      items: [
                              {id: "itemText"},
                              {type: "separator"},
							  entities,
							  {type: "separator"},
							  events,
							  {type: "separator"},
							  {id: "delete", text: "Delete", img: "close.gif"},
							  {type: "separator"},
							  {id: "scale", text: "scale", img: "scalability.gif"},
							  
                      ]
                    });

  myContextMenu.attachEvent("onClick", menuhandler);
  myContextMenu.setItemText("itemText", tree.getItemText(id));
  myContextMenu.showContextMenu(obj.x, obj.y);
      },
    });
  return false; // prevent default context menu
}



function menuhandler(id, zoneId, cas)
{
 
  if(id!="itemText"){
	if(id=="scale")
	 scale(tree.getSelectedItemId())
 
    else if(id=="delete")
    {
      
      var selected_node = tree.getSelectedItemId();
      var childrens = tree.getAllSubItems(selected_node);
      if(childrens!="")
       {
		 childrens=childrens.split(",");
		 
         childrens.forEach(nodeid => {

			 tree.deleteItem(nodeid);});
             
       }
      if(selected_node>1)
        tree.deleteItem(tree.getSelectedItemId());
    }
    else if(id.startsWith("entity"))
      create_device(id.substr(7,id.length)); 
	else if(id.startsWith("event"))
	  create_event(id.substr(6,id.length),tree.getSelectedItemId());
  }

}

function scale(nodeid)
{
	var windows = new dhtmlXWindows();
	windows.setSkin('dhx_web');

	var scale_win = windows.createWindow('scale_w', 0, 0, 300, 400);
	var str = [
		{ type:"input" , name:"id_start", label:"First ID"  },
		{ type:"input" , name:"id_end", label:"Last ID"  },
		{ type:"button" , name:"ok_button", value:"Save"  },
		{ type:"button" , name:"cancel_button", value:"Cancel"  }
	];
	var scale_form = scale_win.attachForm(str);

	var temp_name = tree.getItemText(nodeid);

	while(temp_name.indexOf("[")>=0)
	{
     temp_name=temp_name.substr(temp_name.indexOf("[")+1);
	}
	temp_name=tree.getItemText(nodeid).substr(0,tree.getItemText(nodeid).length-temp_name.length);
	
	scale_form.attachEvent('onButtonClick', function(name, command){
		if(name=="ok_button"){
		   scale_form.send("./rest_api/scale.php?nodeid="+nodeid+"&name="+temp_name, function (){
			 tree.destructor();
			 createTreeConfig();
		
	   
	});
	}
	else scale_win.close();
});
}

function additem(typ, id)
{
    //var parentId = tree.getParentId(tree.getSelectedItemId());
    var selected = tree.getSelectedItemId();
    var nodeid;
	var elems =typ.split("_");
	typ=elems[0];
    $.ajax
    ({
     url: './data/getid.php',
     type: 'get',
     contentType: false,
     processData: false,
     async: false,
     success: function(response)
     {
      nodeid=response;
      if (selected!= null){
		dp.setUpdateMode("off");
		var parentid=selected,prefix="";
		if(parentid>1){
		 var temp= tree.getItemText(parentid);
		 prefix=temp.substr(temp.indexOf('['),temp.length)+":";
		}
		if (id==null) id=parentid;
        switch (elems[1]) {
          case "2" :
            tree.insertNewItem(selected, nodeid,"house "+prefix+"["+id+"]", undefined,"home.gif","home.gif","home.gif");
            tree.setUserData(nodeid,"type","2");
            break;
          case "3" :
            tree.insertNewItem(selected, nodeid,"charge_station "+prefix+"["+id+"]",undefined,"c-station.gif","c-station.gif","c-station.gif");
            tree.setUserData(nodeid,"type","3");
            break;
          case "4" :
            tree.insertNewItem(selected, nodeid,"HC "+prefix+"["+id+"]");
            tree.setUserData(nodeid,"type","4");
            tree.setItemImage(nodeid,"spina.gif");
            break;
          case "5" :
            tree.insertNewItem(selected, nodeid,"CP "+prefix+"["+id+"]");
            tree.setUserData(nodeid,"type","5");
            tree.setItemImage(nodeid,"spina.gif");
            break;
          case "6" :
            tree.insertNewItem(selected, nodeid,"PV "+prefix+"["+id+"]", undefined,"pv_panel.gif","pv_panel.gif","pv_panel.gif");
            tree.setUserData(nodeid,"type","6");
            break;
          case "7" :        
            tree.insertNewItem(selected, nodeid,"ecar ["+id+"]",undefined,"car-Icon.gif","car-Icon.gif","car-Icon.gif");
            tree.setUserData(nodeid,"type","7");
            break;
          case "8" :        
            tree.insertNewItem(selected, nodeid,"DEVICE "+prefix+"["+id+"]");
            tree.setUserData(nodeid,"type","8")
            tree.setItemImage(nodeid,"spina.gif");
            break;
          case "9" :        
            tree.insertNewItem(selected, nodeid,"BG "+prefix+"["+id+"]");
            tree.setUserData(nodeid,"type","9")
            tree.setItemImage(nodeid,"spina.gif");
            break;
          case "10" :        
            tree.insertNewItem(selected, nodeid,"BAT "+prefix+"["+id+"]", undefined,"battery.gif","battery.gif","battery.gif");
            tree.setUserData(nodeid,"type","10")
            tree.setItemImage(nodeid,"spina.gif");
			break;
		  case "11" :        
            tree.insertNewItem(selected, nodeid,"FLEET "+prefix+"["+id+"]", undefined,"fleet.png","fleet.gif","fleet.png");
            tree.setUserData(nodeid,"type","11")
            tree.setItemImage(nodeid,"fleet.png");
			break;
		  case "12" :        
            tree.insertNewItem(selected, nodeid,"TRANSFORMER "+prefix+"["+id+"]", undefined,"battery.gif","battery.gif","battery.gif");
            tree.setUserData(nodeid,"type","12")
            tree.setItemImage(nodeid,"epanel.png");
			break;	 
		  case "102" :        
            tree.insertNewItem(selected, nodeid,"PREDICTION_UPDATE "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","102")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "109" :        
            tree.insertNewItem(selected, nodeid,"BACKGROUND_LOAD "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","109")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "110" :        
            tree.insertNewItem(selected, nodeid,"BACKGROUND_LOAD "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","110")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "101" :        
            tree.insertNewItem(selected, nodeid,"EV_CHARGE ["+id+"]",undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","101")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "106" :        
            tree.insertNewItem(selected, nodeid,"HC_LOAD "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","106")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "107" :        
            tree.insertNewItem(selected, nodeid,"ENERGY_COST "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","107")
            tree.setItemImage(nodeid,"schedule.gif");
		  case "108" :        
            tree.insertNewItem(selected, nodeid,"LOAD "+prefix/*+"["+id+"]"*/,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","108")
            tree.setItemImage(nodeid,"schedule.gif");
			break;
		  case "111" :        
            tree.insertNewItem(selected, nodeid,"GRID_MIX "+prefix,undefined,"schedule.gif","schedule.gif","schedule.gif");
            tree.setUserData(nodeid,"type","111")
			tree.setItemImage(nodeid,"schedule.gif");
		  break;
		
   
    }
  dp.sendData();
  tree.openItem(selected);
  dp.setUpdateMode("cell"); 
  }
}
});
return parseInt(nodeid)+1;
}

var window_1;

function create_device(device_type){

  var windows = new dhtmlXWindows();
	windows.setSkin('dhx_web');

	window_1 = windows.createWindow('window_1', 300, 100, 500, 500);
	form_1 = window_1.attachForm();
	form_1.enableLiveValidation(false);
	form_1.loadStruct('data/create_device_form.xml?devtype='+device_type);
  
  form_1.attachEvent('onChange', function (name, value,state)
  {
    if(name=="individual" && value!="0")
    {
      if(form_1.isItem("data"))
        form_1.removeItem("data");
      
      form_1.loadStruct('./data/create_device_form.xml?devtype='+device_type+"&devid="+value);
   

    }	
    return false;
  }
  );
  
//VALIDAZIONE FORM

  	var messages = []; //creo un vettore inizialmente vuoto che dovrà contenere i messaggi di notifica
	  function check_validate(n,value){ //n fa riferimento al nome del campo, value al valore che l'utente ha inserito
		switch (n) {
        case "id" :
			return dhtmlxValidation.isValidInteger(value)?true:'ID must be an integer';
            break;
		
		case "type" :
			return dhtmlxValidation.isValidInteger(value)?true:'type must be an integer';
            break;
		
		case "peakLoad" :
			return dhtmlxValidation.isValidInteger(value)?true:'peakLoad must be an integer';
            break;

		case "name" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'name must be a string';
            break;

		case "Location_ID" :
			return dhtmlxValidation.isValidInteger(value)?true:'Location ID must be a string';
            break;

		case "Entry Time" :
			return dhtmlxValidation.isValidDatetime(value)?true:'Entry Time must be a valid DateTime';
            break;

		case "Exit Time" :
			return dhtmlxValidation.isValidDatetime(value)?true:'Exit Time must be a valid DateTime';
            break;

		case "Device_model" :
			return dhtmlxValidation.isValidNumeric(value)?true:'Device_model must be a valid number';
            break;
		
		case "Peak_Power" :
			return dhtmlxValidation.isValidNumeric(value)?true:'Peak_Power must be a valid number';
            break;

		case "Battery_ID" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Battery_ID must be a valid string';
            break;

		case "Inverter_device_model" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Inverter_device_model must be a valid string';
            break;

		case "PV_Panels" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Panels must be a valid string';
            break;

		case "No" :
			return dhtmlxValidation.isValidNumeric(value)?true:'No must be a valid number';
            break;

		case "Azimuth" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Azimuth must be a valid string';
            break;

		case "Tilt" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Tilt must be a valid string';
            break;

		case "Noct" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Noct must be a valid string';
            break;

		case "Temperature_" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Temp must be a valid string';
            break;

		case "Albedo" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Albedo must be a valid string';
            break;

		case "CP_Name" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'CP_Name must be a valid string';
            break;

		case "Charging_Capacity" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Charging_Capacity must be a valid string';
            break;

		case "Comment" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Comment must be a valid string';
            break;

		case "Connector_Type" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'Connector_Typee must be a valid string';
            break;

		case "capacity" :
			return dhtmlxValidation.isValidNumeric(value)?true:'capacity must be a valid number';
            break;

		case "cheff" :
			return dhtmlxValidation.isValidNumeric(value)?true:'cheff must be a valid number';
            break;

		case "dis_eff" :
			return dhtmlxValidation.isValidNumeric(value)?true:'dis_eff must be a valid number';
            break;

		case "maxallen" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'maxallen must be a valid string';
            break;

		case "maxchpowac" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxchpowac must be a valid number';
            break;

		case "maxchpowdc" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxchpowdc must be a valid number';
            break;

		case "maxdispowac" :
			return dhtmlxValidation.isValidNumeric(value)?true:'maxdispowac must be a valid number';
            break;

		case "maxdispowdc" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'maxdispowdc must be a valid number';
            break;

		case "minallen" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'minallen must be a valid string';
            break;

		case "model" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'model must be a valid string';
            break;

		case "sbch" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'sbch must be a valid string';
            break;

		case "sbdis" :
			return dhtmlxValidation.isValidAplhaNumeric(value)?true:'sbch must be a valid string';
            break;
		default:
		return true;
		}
		return true //ignore the validation if the checkbox is not checked
	}

//VALIDAZIONE FORM

	    form_1.attachEvent("onValidateError", function (nome, value, result){//evento in caso di errori di validazione
			var x = check_validate(nome,value); //contiene il nome del campo errato e il valore che deve assumere
			if(x!=true) //se è diverso da true deve riempire il vettore relativo al messaggio di notifica
			messages.push(x);
		});

  form_1.attachEvent('onButtonClick', function (name){
    if(name=="add")
    {	
		var result = form_1.validate(); //valida i campi inseriti dall'utente
		if (result==false){ //innesca l'alert con i relativi messaggi di notifica
					dhtmlx.alert({
				title:"ATTENZIONE",
				type:"alert-error",
				text:messages.join('<br><br>')
					});
						messages = [];//pulisco il vettore che contiene i messaggi di notifica
			return;
			
		}

		//Controllo ID univoco all'aggiunta di un nuovo dispositivo

		var children = tree.getAllChildless(); //prendo i figli del nodo radice
		var j = false;

		children.split(',').forEach(element => {
			var text = tree.getItemText(element); //torna la stringa "DEVICE [x]:[y]"
			var values = text.split(':') //torna la stringa "DEVICE [x],[y]"
			if(values[1]=='['+form_1.getItemValue("id")+']'){ //confronto [y] con [id inserito dall'utente]
				j=true; //se già c'è un nodo con quel id setta j a true
				return;
			}
		});
		if(j){
			dhtmlx.alert({
				title:"ATTENZIONE",
				type:"alert-error",
				text:"Il campo ID deve essere univoco"
					});
		}else{//se non ci sono errori di validazione si deve proseguire con l'aggiunta del dispositivo

		var nodeid=additem(device_type,form_1.getItemValue("id"));
		
        form_1.send("./data/save_node_properties.php?nodeid="+nodeid, function (){
        
        //console.log("properties saved");
        
  		grid_1.load('./data/static_parameters.xml?devid='+nodeid, 'xml');
  		//grid_2.load('./data/dynamic_parameters.xml?devid='+nodeid, 'xml');

      });
      window_1.close();
		}
    }


  });

  window_1.button('minmax').show();
  window_1.button('minmax').enable();
  window_1.show();

}




function create_event(event_type,id){

var windows = new dhtmlXWindows();
  windows.setSkin('dhx_web');

  window_1 = windows.createWindow('window_1', 300, 100, 500, 500);
  form_1 = window_1.attachForm();
  form_1.loadStruct('data/create_event_form.xml?evtype='+event_type+"&id="+id);

form_1.attachEvent('onChange', function (name, value,state)
{
  if(name=="event" && value!="0")
  {
	if(form_1.isItem("data"))
	  form_1.removeItem("data");
	
	form_1.loadStruct('./data/create_event_form.xml?evtype='+event_type+"&profid="+value+"&id="+id);
 

  }	
  return false;
}
);




form_1.attachEvent('onButtonClick', function (name){
    if(name=="add")
    {
		event_type=parseInt(event_type)+100;
        var nodeid=additem("0_"+event_type,form_1.getItemValue("ID"));
        form_1.send("./data/save_node_properties.php?nodeid="+nodeid, function (){
        
        //console.log("properties saved");
        
  		grid_1.load('./data/static_parameters.xml?devid='+nodeid, 'xml');
  		//grid_2.load('./data/dynamic_parameters.xml?devid='+nodeid, 'xml');

      });
      window_1.close();
    }
	else if(name=="load"){
	 var instance=form_1.getItemValue("profile");
	 var value = form_1.getItemValue("event");
	 form_1.loadStruct('./data/create_event_form.xml?evtype='+event_type+"&profid="+value+"&inst="+instance);
	

	}
  });

  window_1.button('minmax').show();
  window_1.button('minmax').enable();
  window_1.show();

}

function new_sim()
{
  var windows = new dhtmlXWindows();
	windows.setSkin('dhx_web');

	var window_1 = windows.createWindow('window_1', 0, 0, 300, 400);
	var str = [
		{ type:"settings" , labelWidth:80, inputWidth:250, position:"absolute"  },
		{ type:"input" , name:"form_input_1", label:"Name", labelWidth:250, labelLeft:5, labelTop:5, inputLeft:5, inputTop:21  },
		{ type:"button" , name:"btn_new", label:"Button", value:"New", width:"75", inputWidth:75, inputLeft:5, inputTop:50  },
		{ type:"button" , name:"btn_cancel", label:"Button", value:"Cancel", width:"100", inputWidth:100, inputLeft:100, inputTop:50  }
	];
	var simul_name = window_1.attachForm(str);



	window_1.button('minmax').show();
	window_1.button('minmax').enable();
}

/**********END TREE*****************/


var ribbon_3=layout_2.attachRibbon();

ribbon_3.attachEvent('onXLE', function(){
	$.ajax
				  ({
					 url: './rest_api/configuration_list.php',
					 type: 'get',
					 contentType: false,
					 processData: false,
					 async: true,
					 success: function(response)
						  {
							   var jsonobj = JSON.parse(response);
							   jsonobj.forEach(simid => {ribbon_3.getCombo("config_select").addOption([[simid.id,simid.name]]);});
						   }
						});
					});

ribbon_3.loadStruct({
skin : "dhx_skyblue", icons_path : "./codebase/imgs/", items : [

{id : "block_4", text : "current configuration", text_pos : "top", type : "block", mode : "rows", list : [

{id : "config_select", text : "select configuration", type : "buttonCombo", width : 140, items : [

		

]},
{id : "del_conf", text : "delete", type : "button"}

]},
{id : "block_5", text : "import/export", text_pos : "top", type : "block", mode : "rows", list : [

{id : "button_6", text : "upload", type : "button"},
{id : "button_7", text : "download", type : "button"}

]}

]
	});

	ribbon_3.attachEvent('onClick', function(id){
		if (id=="del_conf")
		{
			var sim_id=ribbon_3.getCombo("config_select").getSelectedValue();
			var fd = new FormData();
    		fd.append('sim_id',sim_id );
			$.ajax
				  ({
					 url: './rest_api/del_configuration.php',
					 type: 'post',
					 contentType: false,
					 processData: false,
					 data: fd,
					 async: true,
					 success: function(response)
						  {
							if(response =="1"){
								tree.destructor();
								createTreeConfig();
								ribbon_3.getCombo("config_select").deleteOption(sim_id);
								ribbon_3.getCombo("config_select").selectOption(1);
								
						}
					   }
						});
		
		}
	});



	ribbon_3.getCombo("config_select").attachEvent('onChange', function(id, value){
	var sim_id=ribbon_3.getCombo("config_select").getSelectedValue();
	//console.log(sim_id);
	$.ajax
				  ({
					 url: './rest_api/set_configuration.php?conf='+sim_id,
					 type: 'get',
					 contentType: false,
					 async: true,
					 success: function(response)
						  {
							tree.destructor();
							createTreeConfig();
							ribbon_3.getCombo("config_select")
						}
						});
					

	});







   


	sidebar.addItem({id: 'simulation_sitem', text: 'Simulation', icon: 'sidebar_item_icon.png'});
	var simulation_sitem = sidebar.cells('simulation_sitem');
	var layout_4 = simulation_sitem.attachLayout('2E');

	var cell_10 = layout_4.cells('a');
	cell_10.setText('Simulation Parameters');

	
	
	configuration_form = cell_10.attachForm();
	
	configuration_form.loadStruct("data/simulator_form.xml")
	
	configuration_form.attachEvent('onChange', function(id, value){
		
		if(id === "type") 
			{
				var fd = new FormData();
    			fd.append('protocol',value );
				$.ajax({
				url: 'rest_api/config.php',
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				
					});


			}


	});
	
    configuration_form.attachEvent('onButtonClick', function(name, command){
		if(name === "scheduler") {
			/*
			var windows = new dhtmlXWindows();
			windows.setSkin('dhx_web');

			var Scheduler = windows.createWindow('Scheduler', 400, 400, 600, 800);
			Scheduler.attachURL('scheduler/index.html', true);
			var status_3 = Scheduler.attachStatusBar();
			status_3.setText('');

			Scheduler.setText('Scheduler');
			Scheduler.button('minmax').show();
			Scheduler.button('minmax').enable();
			*/
            if(configuration_form.isItemChecked('type','2.0'))
				window.open('scheduler/index.php');
			else
				window.open('xmppscheduler/index.php');
		}
		
	});




	var cell_11 = layout_4.cells('b');
	cell_11.hideHeader();
	//cell_11.setText('Simulation Control');
	cell_11.attachURL('./mdn/index2.html', true);
    




	sidebar.addItem({id: 'vis_sitem', text: 'Visualization', icon: 'sidebar_item_icon.png'});

	var vis_sitem = sidebar.cells('vis_sitem');
	tabbar = vis_sitem.attachTabbar();
	tabbar.enableTabCloseButton(true);
	tabbar.addTab('vis_tab','Search');
	var tab_search = tabbar.cells('vis_tab');
	tab_search.setActive();


	tab_search.attachURL(visualization_page);
/*
	sidebar.attachEvent('onSelect', function(id, lastId){
	
		
		if(id==='vis_sitem')
		   window.open(visualization_page);
	});



	sidebar_2.attachEvent('onSelect', function(id, lastId){
		alert('onSelect');
	});


	sidebar_2.attachEvent('onContentLoaded', function(id){
		alert('onContentLoaded');
	});


	sidebar_2.attachEvent('onXLS', function(){
		alert('onXLS');
	});


	sidebar_2.attachEvent('onXLE', function(){
		alert('onXLE');
	});
*/
	var toolbar = a.attachToolbar();
	toolbar.setIconsPath('./codebase/imgs/');
	
	toolbar.loadStruct('./data/toolbar.xml', function() {});
	var status_2 = a.attachStatusBar();
	status_2.setText('');
        toolbar.attachEvent('onClick', function(id){
		if(id=="logout")
		{
			window.location="logout.php";
			
		}
		else if(id=="newconf" || id=="saveas")
		{getNameWindow(id)}
	});

function getNameWindow(action){
	var windows = new dhtmlXWindows();
	windows.setSkin('dhx_web');

	var GetNameW = windows.createWindow('GetNameW', 0, 0, 300, 400);
	var str = [
		{ type:"input" , name:"config_name", label:"Name"  },
		{ type:"button" , name:"ok_button", value:"Save"  },
		{ type:"button" , name:"cancel_button", value:"Cancel"  }
	];
	var NameForm = GetNameW.attachForm(str);

	NameForm.attachEvent('onButtonClick', function(name, command){
		
		var conf_id = ribbon_3.getValue("config_select");

		var fd = new FormData();
		var conf_name= NameForm.getItemValue("config_name");
		fd.append('newsim',conf_name );
		fd.append('action',action);
		fd.append('template',ribbon_3.getCombo("config_select").getSelectedText());


		$.ajax({
		url: 'rest_api/new_conf.php',
		type: 'post',
		data: fd,
		contentType: false,
		processData: false,
		success: function(response){
			if(response>0)
			{
				tree.destructor();
				createTreeConfig();
				ribbon_3.getCombo("config_select").addOption([[response,conf_name]]);
				ribbon_3.getCombo("config_select").selectOption(response);
				GetNameW.close();
			}



		}
			});


		
	});


	GetNameW.setText('New Configuration');
	GetNameW.button('minmax').show();
	GetNameW.button('minmax').enable();
}

	/*
	

	var ConfigurationUpload = windows.createWindow('ConfigurationUpload', 0, 0, 300, 400);
	var str = [
		{ type:"upload" , name:"form_upload_1", inputWidth:330, inputHeight:60, titleScreen:true, url:"./codebase/dhtmlxform_item_upload.php", swfPath:"./codebase/uploader.swf", swfUrl:"./dhtmlxform_item_upload.php"  }
	];
	var form_2 = ConfigurationUpload.attachForm(str);


	var status_4 = ConfigurationUpload.attachStatusBar();
	status_4.setText('');

	ConfigurationUpload.setText('Upload Configuration');
	ConfigurationUpload.button('minmax').show();
	ConfigurationUpload.button('minmax').enable();
	*/




}



</script>
</body>
</html>
