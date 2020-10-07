<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>




<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Simulator Controller - GreenCharge Visualization and Evaluation Tool</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Drag--Drop-Upload-Form.css">

    <link rel="stylesheet" href="assets/css/countdown-timer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightpick@1.3.4/css/lightpick.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">

  <?php
  require 'vendor/autoload.php';
  use Supervisor\Supervisor;
  use Supervisor\Connector\XmlRpc;
  use fXmlRpc\Client;
  use fXmlRpc\Transport\HttpAdapterTransport;
  use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
  use \Http\Message\MessageFactory\DiactorosMessageFactory as MessageFactory;

  //Create GuzzleHttp client
  $guzzleClient = new \GuzzleHttp\Client(['auth' => ['cossmic', '2525']]);

  // Pass the url and the guzzle client to the XmlRpc Client
  $client = new Client(
      'http://parsec2.unicampania.it:9001/RPC2',
      new HttpAdapterTransport(
          new MessageFactory(),
          new GuzzleAdapter($guzzleClient))
  );

  // Pass the client to the connector
  // See the full list of connectors bellow
  $connector = new XmlRpc($client);

  $supervisor = new Supervisor($connector);

  // returns Process object
  $process = $supervisor->getProcess('uiosimulator');

  // returns array of process info
  //foreach ( $supervisor->getProcessInfo('uiosimulator') as $element){
  //	echo $element." ";
  //}
  // same as $supervisor->stopProcess($process);
  //$supervisor->stopProcess('uiosimulator');

  // Don't wait for process start, return immediately
  //$supervisor->startProcess($process, false);

  // returns true if running
  // same as $process->checkState(Process::RUNNING);
  $process->isRunning();

  // returns process name

  // returns process information
  $process->getPayload();


  if(!empty($_GET["action"]) && isset($_GET["action"]))
  {
    if($_GET["action"] == "start"){
      $supervisor->startProcess('uiosimulator',true);
    }
    elseif ($_GET["action"] == "stop") {
      $supervisor->stopProcess('uiosimulator');
    }
	header('Location: controller.php?msg='.$msg);
	}



  ?>







    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary2 p-0" style="background-color: #599f4f;">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>GreenCharge</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu">
                                        <h6 class="dropdown-header">alerts center</h6>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                            </div>
                                        </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a></div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu">
                                        <h6 class="dropdown-header">alerts center</h6>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar4.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Hi there! I am wondering if you can help me with a problem I've been having.</span></div>
                                                <p class="small text-gray-500 mb-0">Emily Fowler - 58m</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar2.jpeg">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>I have the photos that you ordered last month!</span></div>
                                                <p class="small text-gray-500 mb-0">Jae Chun - 1d</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar3.jpeg">
                                                <div class="bg-warning status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Last month's report looks great, I am very happy with the progress so far, keep up the good work!</span></div>
                                                <p class="small text-gray-500 mb-0">Morgan Alvarez - 2d</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar5.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</span></div>
                                                <p class="small text-gray-500 mb-0">Chicken the Dog · 2w</p>
                                            </div>
                                        </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a></div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                <h3 class="text-dark mb-1">Simulator Controller</h3>
            </div>

  		<div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Progress Simulation Time</h4>
                        <div id="wrapper">
                            <div class="container">
                                <div id="clockdiv">
                                    <div class="clock-wrapper"><span class="hours"> </span>
                                        <div class="smalltext">
                                            <p>Hours </p>
                                        </div>
                                    </div>
                                    <div class="clock-wrapper"><span class="minutes"> </span>
                                        <div class="smalltext">
                                            <p>Minutes </p>
                                        </div>
                                    </div>
                                    <div class="clock-wrapper"><span class="seconds"> </span>
                                        <div class="smalltext">
                                            <p>Seconds </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="progress" style="margin-top: 50px;">
                                    <div class="progress-bar" id="myprogress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                </div>
                                <div id="clockdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
      <script>
                    	    getSimTime();
			    var interval = window.setInterval(getSimTime, 5000);
	                    function getSimTime(){
			       	var clock = document.getElementById("clockdiv");
				var myprogress = document.getElementById("myprogress");
        	                    var hoursSpan = clock.querySelector('.hours');
                	            var minutesSpan = clock.querySelector('.minutes');
                        	    var secondsSpan = clock.querySelector('.seconds');

                       		     var xhttp = new XMLHttpRequest();
                       		     xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                   // Typical action to be performed when the document is ready:

                                    var response = xhttp.responseText;
				    var obj = JSON.parse(response);
				    var date = new Date(obj.time * 1000);
	                            hoursSpan.innerHTML = date.getHours();
        	                    minutesSpan.innerHTML = date.getMinutes();
                	            secondsSpan.innerHTML = date.getSeconds();
				    var progress = (date.getHours()*3600 + date.getMinutes()*60 +date.getSeconds());
			            var day = 24*3600;
			            progress= progress/day;
				    progress = progress*100;
				    var str= myprogress.style.width;
				     str =  str.substring(0, str.length - 1);

				    if((Number(str) +10)<progress){
					console.log(Number(str));
					var i;
					for(i = 0; i<11; i++){
						actual = Number(str)+i;
						console.log(actual);
						myprogress.innerHTML = String(actual) +"%";
						myprogress.style.width = String(actual) + "%";
					}

					}

                                }
                            };
                            xhttp.open("GET", "http://parsec2.unicampania.it:10008/gettime", true);
                            xhttp.send();
			   }
                          </script>
            </div>

            <div class="card" style="margin-top: 30px;">
                <div class="card-body" style="margin-bottom: 30px;"><div class="dashed_upload">
      <div class="wrapper">
        <div class="drop" style="margin-top: 30px; ">
            <div class="cont"><i class="fa fa-cloud-upload"></i>
                <div class="tit">
                    Drag &amp; Drop
                </div>
                <div class="desc">
                    or
                </div>
                <div class="browse">
                    click here to browse
                </div>
            </div><output id="list"></output><input id="files" multiple name="files[]" type="file" /></div>
      </div>
      </div></div>
            </div>
            <div>
                <fieldset>
                    <legend>Do you want to use Adaptor?</legend>
                    <div class="custom-control custom-radio"><input type="radio" id="customRadio1" class="custom-control-input" name="customRadio" checked=""><label class="custom-control-label" for="customRadio1">Use Adaptor</label></div>
                    <div class="custom-control custom-radio"><input type="radio" id="customRadio2" class="custom-control-input" name="customRadio"><label class="custom-control-label" for="customRadio2">Use an XMPP Scheduler</label></div>
                </fieldset>
            </div>

            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Start Simulation</h4>
                        <p class="card-text" >Click Here to Start.</p><a class="btn btn-success btn-icon-split" role="button" onclick="startProcess()"><span class="text-white-50 icon"><i class="fas fa-check"></i></span><span class="text-white text">Start</span></a></div>
                        <script>
                                  function startProcess() {
                                    window.location.href = 'controller.php?action=start';                             }
                        </script>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Stop Simulation</h4>
                        <p class="card-text">Click Here to Stop.</p><a class="btn btn-danger btn-icon-split" role="button" onclick="stopProcess()"><span class="text-white-50 icon"><i class="fas fa-trash"></i></span><span class="text-white text">Stop</span></a></div>
                        <script>
                                  function stopProcess() {
                                    window.location.href = 'controller.php?action=stop';                             }
                        </script>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Status</h4>

                        <p class="card-text" id="status">Click Here to get Sim status.</p>
                        </div>

                        <?php
                            function js($o) {
                                echo json_encode($o, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
                            }
                        ?>
                        <script>
                              var interval = window.setInterval(statusProcess, 5000);
                                  function statusProcess() {
                                     var foo = <?php js($process->isRunning()); ?>;
                                     console.log(foo);

                                      var status = document.getElementById("status");
                                      if(foo == true){
                                        status.innerHTML = "Simulator is running";
                                      }
                                      else if (foo == false) {
                                        status.innerHTML = "Simulator is stopped";

                                      }


                                 }
                        </script>
                </div>
            </div>



        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © GreenCharge Visualization and Evaluation Tool 2019</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightpick@1.3.4/lightpick.min.js"></script>
    <script src="assets/js/greencharge.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>

</body>

</html>

