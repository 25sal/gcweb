
<?php $path=''?>

<html><head>

	<link rel="stylesheet" type="text/css" href="play.css">
	<script language="JavaScript" type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $path; ?>Modules/input/Views/input.js"></script>
	
	<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/table.js"></script>
	<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/custom-table-fields.js"></script>

	<script type="text/javascript" src="<?php echo $path; ?>Modules/input/Views/processlist.js"></script>
	<script type="text/javascript" src="<?php echo $path; ?>Modules/input/Views/process_info.js"></script>
	<!--<script type="text/javascript" src="<?php echo $path; ?>Modules/feed/feed.js"></script>-->

	<style>
	input[type="text"] {
			 width: 88%;
	}

	#table td:nth-of-type(1) { width:5%;}
	#table td:nth-of-type(2) { width:10%;}
	#table td:nth-of-type(3) { width:25%;}

	#table td:nth-of-type(7) { width:30px; text-align: center; }
	#table td:nth-of-type(8) { width:30px; text-align: center; }
	#table td:nth-of-type(9) { width:30px; text-align: center; }
</style>
        <link href="Lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="Lib/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="Lib/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="Theme/emon.css" rel="stylesheet">

</head>

<body>
	
	
	<br>
<!--<div id="apihelphead"><div style="float:right;"><a href="api.html"><?php echo _('Input API Help'); ?></a></div></div>-->

<div class="container">
    <div id="localheading"><h2><?php echo _('Simulator Processes'); ?></h2></div>
    
    <div id="processlist-ui" style="padding:20px; background-color:#efefef; display:none">
    
    <div style="font-size:30px; padding-bottom:20px; padding-top:18px"><b><span id="inputname"></span></b> config</div>
    <p><?php echo _('Input processes are executed sequentially with the result being passed back for further processing by the next processor in the input processing list.'); ?></p>
    
        <table class="table">

            <tr>
                <th style='width:5%;'></th>
                <th style='width:5%;'><?php echo _('Order'); ?></th>
                <th><?php echo _('Process'); ?></th>
                <th><?php echo _('Arg'); ?></th>
                <th></th>
                <th><?php echo _('Actions'); ?></th>
            </tr>

            <tbody id="variableprocesslist"></tbody>

        </table>

        <table class="table">
        <tr><th>Add process:</th><tr>
        <tr>
            <td>
                <div class="input-prepend input-append">
                    <select id="process-select"></select>

                    <span id="type-value" style="display:none">
                        <input type="text" id="value-input" style="width:125px" />
                    </span>

                    <span id="type-input" style="display:none">
                        <select id="input-select" style="width:140px;"></select>
                    </span>

                    <span id="type-feed">        
                        <select id="feed-select" style="width:140px;"></select>
                        
                        <input type="text" id="feed-name" style="width:150px;" placeholder="Feed name..." />
                        <input type="hidden" id="feed-tag"/>

                        <span class="add-on feed-engine-label">Feed engine: </span>
                        <select id="feed-engine">
                            <option value=6 >Fixed Interval With Averaging (PHPFIWA)</option>
                            <option value=5 >Fixed Interval No Averaging (PHPFINA)</option>
                            <option value=2 >Variable Interval No Averaging (PHPTIMESERIES)</option>
                        </select>


                        <select id="feed-interval" style="width:130px">
                            <option value="">Select interval</option>
                            <option value=5>5s</option>
                            <option value=10>10s</option>
                            <option value=15>15s</option>
                            <option value=20>20s</option>
                            <option value=30>30s</option>
                            <option value=60>60s</option>
                            <option value=120>2 mins</option>
                            <option value=300>5 mins</option>
                            <option value=600>10 mins</option>
                            <option value=1200>20 mins</option>
                            <option value=1800>30 mins</option>
                            <option value=3600>1 hour</option>
                        </select>
                        
                    </span>
                    <button id="process-add" class="btn btn-info"><?php echo _('Add'); ?></button>
                </div>
            </td>
        </tr>
        <tr>
          <td id="description"></td>
        </tr>
        </table>
    </div>
    <br>
    
    <div id="table"></div>

    <div id="noinputs" class="alert alert-block hide">
            <h4 class="alert-heading"><?php echo _('No inputs created'); ?></h4>
            <p><?php echo _('Inputs is the main entry point for your monitoring device. Configure your device to post values here, you may want to follow the <a href="api">Input API helper</a> as a guide for generating your request.'); ?></p>
    </div>

</div>

<script>


    function update()
    {   
		var path ='';
        $.ajax({ url: path+"Modules/simulator/list.php", dataType: 'json', async: true, success: function(data) {
        
            table.data = data;
            table.draw();
            if (table.data.length != 0) {
                $("#noinputs").hide();
                $("#apihelphead").show();
                $("#localheading").show();
            } else {
                $("#noinputs").show();
                $("#localheading").hide();
                $("#apihelphead").hide();
            }
            
            if (firstrun) {
                firstrun = false;
                load_all(); 
            }
        }});
    }

     function buildtable(){
		 
    var path = "";
    
    var firstrun = true;
    var assoc_inputs = {};

    // Extend table library field types
    for (z in customtablefields) table.fieldtypes[z] = customtablefields[z];

    table.element = "#table";

    table.fields = {
        //'id':{'type':"fixed"},
        'nodeid':{'title':'<?php echo _("ID:"); ?>','type':"fixed"},
        'name':{'title':'<?php echo _("Name"); ?>','type':"text"},
        'description':{'title':'<?php echo _("User"); ?>','type':"text"},
        'processList':{'title':'<?php echo _('Progress'); ?>','type':"processlist"},
        'time':{'title':'last updated', 'type':"updated"},
        'value':{'type':"value"},

        // Actions
        'edit-action':{'title':'', 'type':"edit"},
        'delete-action':{'title':'', 'type':"delete"},
        'view-action':{'title':'', 'type':"iconbasic", 'icon':'icon-wrench'}

    }

    table.groupprefix = "Node ";
    table.groupby = 'nodeid';

    update();
    var updater = setInterval(update, 10000);

    $("#table").bind("onEdit", function(e){
        clearInterval(updater);
    });

    $("#table").bind("onSave", function(e,id,fields_to_update){
        //input.set(id,fields_to_update);
        updater = setInterval(update, 10000);
    });

    $("#table").bind("onDelete", function(e,id){
        //input.remove(id);
        update();
    });
    

    
//------------------------------------------------------------------------------------------------------------------------------------
// Process list UI js
//------------------------------------------------------------------------------------------------------------------------------------
 
    $("#table").on('click', '.icon-wrench', function() {
        
        var i = table.data[$(this).attr('row')];
        console.log(i);
        processlist_ui.inputid = i.id;
        
        var processlist = [];
        if (i.processList!=null && i.processList!="")
        {
            var tmp = i.processList.split(",");
            for (n in tmp)
            {
                var process = tmp[n].split(":"); 
                processlist.push(process);
            }
        }
        
        processlist_ui.variableprocesslist = processlist;
        processlist_ui.draw();
        
        // SET INPUT NAME
        var inputname = "";
        if (processlist_ui.inputlist[processlist_ui.inputid].description!="") {
            inputname = processlist_ui.inputlist[processlist_ui.inputid].description;
            $("#feed-name").val(inputname);
        } else {
            inputname = processlist_ui.inputlist[processlist_ui.inputid].name;
            $("#feed-name").val("node:"+processlist_ui.inputlist[processlist_ui.inputid].nodeid+":"+inputname);
        }
        
        $("#inputname").html("Node"+processlist_ui.inputlist[processlist_ui.inputid].nodeid+": "+inputname);
        
        $("#feed-tag").val("Node:"+processlist_ui.inputlist[processlist_ui.inputid].nodeid);
        
        $("#processlist-ui").show();
        window.scrollTo(0,0);
        
    });
}
function load_all()
{
    for (z in table.data) assoc_inputs[table.data[z].id] = table.data[z];
    console.log(assoc_inputs);
    processlist_ui.inputlist = assoc_inputs;
    
    // Inputlist
    var out = "";
    for (i in processlist_ui.inputlist) {
      var input = processlist_ui.inputlist[i];
      out += "<option value="+input.id+">Node "+input.nodeid+":"+input.name+" "+input.description+"</option>";
    }
    $("#input-select").html(out);
    
    $.ajax({ url: path+"Modules/input/feedlist.php", dataType: 'json', async: true, success: function(result) {
        
        var feeds = {};
        for (z in result) feeds[result[z].id] = result[z];
        
        processlist_ui.feedlist = feeds;
        // Feedlist
        var out = "<option value=-1>CREATE NEW:</option>";
        for (i in processlist_ui.feedlist) {
          out += "<option value="+processlist_ui.feedlist[i].id+">"+processlist_ui.feedlist[i].name+"</option>";
        }
        $("#feed-select").html(out);
    }});
    
    
    $.ajax({ url: path+"Modules/input/getallprocesses.php", async: true, dataType: 'json', success: function(result){
        processlist_ui.processlist = result;
        var processgroups = [];
        var i = 0;
        for (z in processlist_ui.processlist)
        {
            i++;
            var group = processlist_ui.processlist[z][5];
            if (group!="Deleted") {
                if (!processgroups[group]) processgroups[group] = []
                processlist_ui.processlist[z]['id'] = z;
                processgroups[group].push(processlist_ui.processlist[z]);
            }
        }

        var out = "";
        for (z in processgroups)
        {
            out += "<optgroup label='"+z+"'>";
            for (p in processgroups[z])
            {
                out += "<option value="+processgroups[z][p]['id']+">"+processgroups[z][p][0]+"</option>";
            }
            out += "</optgroup>";
        }
        $("#process-select").html(out);
        
        $("#description").html(process_info[1]);
        processlist_ui.showfeedoptions(1);
    }});
   
    processlist_ui.events();
}
</script>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<table>
<tr><td>Sim01</td>
<td><div id="status" class="statusdisabled"></div></td>
<td><button id="start" class="startenabled"></button></td>
<td><button id="stop" class="stopdisabled"></button></td>
</tr></table>
<table>
<tr><th>Simulation Progress</th><th></th></tr>	
<tr><td><div id="log">0 %</div></td><td><div id="bar" class="barreset"></div></td></tr>
</table>

<table>
<tr><th>Time Progress</th><th></th></tr>	
<tr><td><div id="timelog">00:00</div></div></td><td><div id="timebar" class="barreset"></div></td></tr>
</table>

</body>
<script>
	var path='';
$(document).ready(function() {
	
	buildtable();
    var maxWidth = 400;
    var duration = 3000;
    var $log = $('#log');
    var $start = $('#start');
    var $stop = $('#stop');
    var $status = $('#status');
    var timer;
    var simulation="stopped";
    $stop.attr('disabled', true);
    
    $start.on('click', function() {
  
	  
		$start.toggleClass("startdisabled");
		
	
		
		if (simulation==="stopped" || simulation==="paused"){
		if (simulation==="stopped") 
		   $status.toggleClass("statusenabled");
			  
		
			   
			$stop.addClass("stopdisabled");
			$stop.removeClass("stopenabled");
			simulation="running";
			$stop.attr('disabled', true);
			var $bar = $('#bar');
			Horloge(maxWidth);
			timer = setInterval('Horloge('+maxWidth+')', 100);

			$bar.animate({
				width: maxWidth
			}, duration, function() {
				$(this).css('background-color', 'green');
				$start.attr('disabled', true);
				//$stop.attr('disabled', true);
				$log.html('100 %');
				clearInterval(timer);
				$stop.attr('disabled', false);
				$stop.addClass("stopenabled");
				$stop.removeClass("stopedisabled");
			});
	   }
	   else{
		    simulation="paused"
		    clearInterval(timer);
			var $bar = $('#bar');
			$bar.stop();
		
			var w = $bar.width();
			var percent = parseInt((w * 100) / maxWidth);
			$log.html(percent + ' %');
		    $stop.attr('disabled', false);
		    $stop.addClass("stopenabled");
			$stop.removeClass("stopedisabled");
		   
		   
		   }
    });

    $stop.on('click', function() {
		clearInterval(timer);
		simulation="stopped";
        $start.addClass("startenabled");
		$start.removeClass("startdisabled");
		$stop.addClass("stopdisabled");
		$stop.removeClass("stopenabled");
		$status.toggleClass("statusenabled");
		$log.html('0 %');
		$stop.attr('disabled', true);
		$start.attr('disabled', false);
		var $bar = $('#bar');
		$bar.css('background-color', 'yellow');
		$bar.css('width', '0px');
	
    });

});

function Horloge(maxWidth) {
    var w = $('#bar').width();
    var percent = parseInt((w * 100) / maxWidth);
    $('#log').html(percent + ' %');
}


</script>
</html>
