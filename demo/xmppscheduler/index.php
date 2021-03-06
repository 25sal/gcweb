<?php
  session_start();
  $data = yaml_parse_file($_SESSION["workingdir"]."/config.yml");
  $user_jid= $data['config']['userjid']."/".$data['config']['scheduler'];
  $password = $data['config']['xmpp_password'];
  $http_post_port =  $data['config']['adaptor_port'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>File</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/style.css">
       <script src="assets/papaparse.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
	<link rel=stylesheet href=https://cdn.jsdelivr.net/npm/pretty-print-json@0.2/dist/pretty-print-json.css>
	<script src=https://cdn.jsdelivr.net/npm/pretty-print-json@0.2/dist/pretty-print-json.min.js></script>

	<script src="./assets/notification.js"> </script>
<script>
     <?php echo "   var http_post_port=".$http_post_port.";"; ?>
</script>	
<script type='text/javascript'
	src='assets/strophe.umd.js'></script>
<script type='text/javascript'
	src='assets/echobot.js'></script>

</head>
<body>
	<div class="container" align=”center” onload="init_scheduler();">
		<!-- da collegare al codice javascript -->
		<div class="Title">
			<h1>Interactive Scheduler</h1><hr>
		</div>

		<div id='login' style='text-align: center'>
			<form name='cred'>
			  <label for='jid'>JID:</label>
			  <input type='text' value="<?php echo $user_jid; ?>"  id='jid' disabled/>
			  <label for='pass'>Password:</label>
			  <input type='password' value="<?php echo $password; ?>" id='pass' />
			  <input type='checkbox' checked onclick="autoresponse()"/> auto
			  <input type='button' id='connect' value='connect' />
			</form>
		  </div>
		  <hr />
		  <div id='log'></div>


	

		  <!-- Modal HTML -->
	<div class="modal fade" id="modalResponse"  tabindex="-1" role="dialog" aria-labelledby="modalResponseLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold" id="resp_id">Response</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!--elemento del popup-->
			<div class="modal-body mx-3">
				<input type="hidden" id="msgid"/>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">SIM-ID:</span>
					</div>
					<input type="text" class="form-control" id="sim_id" disabled>
				</div>

				<div class="input-group mb-3 date" id="div_time" data-target-input="nearest">
					<div class="input-group-prepend">
						<span class="input-group-text">TIME:</span>
					</div>
					<input type="text" class="form-control datetimepicker-input" id="m_time" data-target="#div_time"/>
					<div class="input-group-append" data-target="#div_time" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				</div>

				<h4 class="modal-title w-100 font-weight-bold">Message:</h4><hr>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Subject:</span>
					</div>
					<input type="text" class="form-control" id="m_subject" disabled>
					
				</div>


				<div class="input-group mb-3 date" id="div_ast" data-target-input="nearest">
					<div class="input-group-prepend">
						<span class="input-group-text">AST:</span>
					</div>
					<input type="text" class="form-control datetimepicker-input" id="m_ast" data-target="#div_ast"/>
					<div class="input-group-append" data-target="#div_ast" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">ID:</span>
					</div>
					<input type="text" class="form-control" id="m_id" disabled>
				</div>

				<div class="input-group mb-3" id="div_producer">
					<div class="input-group-prepend">
						<span class="input-group-text">PRODUCER:</span>
					</div>
					<input type="text" class="form-control" id="m_producer">
				</div>

				<div class="input-group mb-3" id="div_version">
					<div class="input-group-prepend">
						<span class="input-group-text">VERSION:</span>
					</div>
					<input type="text" class="form-control" id="m_version">
				</div>

				<!-- priva versione. nota quando si carica e o si preme X o cancel e si riapre il modal il file resta caricato -->
				<!-- <div class="input-group mb-3" id="div_profile">
				<div class="input-group-prepend">
				<span class="input-group-text">PROFILE:</span>
			</div>
			<input type="file"  class="form-control" id="m_profile" accept=".csv">
		</div> -->

		<!-- sdconda versione quello nuovo. il csv resta caricato -->
		<div class="input-group mb-3" id="div_profile">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroupFileAddon01">PROFILE:</span>
			</div>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="m_profile"
				aria-describedby="inputGroupFileAddon01" accept=".csv">
				<label class="custom-file-label" for="m_profile" >Choose file(.csv)</label>
			</div>
		</div>

	</div> <!--fine elementi popup-->
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="button" class="btn btn-primary" id="sendResponse">Send</button>
	</div>
</div>
</div>
</div>
</body>
</html>
