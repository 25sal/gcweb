<?php
  session_start();
  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  $adaptor_address= "http://".$data['config']['adaptor_address'].":".$data['config']['adaptor_port'];
  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rest scheduler</title>
    <style>

html, body {
    width: 100%;
    height: 100%;
    margin: 0px;
    overflow: hidden;
    background-color:white;
}

</style>    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
	<link rel=stylesheet href=https://cdn.jsdelivr.net/npm/pretty-print-json@0.2/dist/pretty-print-json.css>
	<script src=https://cdn.jsdelivr.net/npm/pretty-print-json@0.2/dist/pretty-print-json.min.js></script>


    <link rel="stylesheet" type="text/css" href="../dhtmlx/codebase/fonts/font_roboto/roboto.css"/>
	<link rel="stylesheet" type="text/css" href="../dhtmlx/codebase/dhtmlx.css"/>
		<link rel="stylesheet" type="text/css" href="../dhtmlx/skins/skyblue/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="../dhtmlx/skins/web/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="../dhtmlx/skins/terrace/dhtmlx.css"/>
	<script>
		var adaptor_address = "<?php echo $adaptor_address; ?>";
    </script>
    <script src="assets/papaparse.js"></script>
    <script src="./assets/restscheduler.js"></script> 
    <script src="../dhtmlx/codebase/dhtmlx.js"></script>
    <script src="./assets/notification.js"> </script>
</head>
    <body onload="doOnLoad();">


</body>
</html>
