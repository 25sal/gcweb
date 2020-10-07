<?php


session_start();

include("include/DatabaseManager.php");
$db = new DatabaseManager();

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
    <title>Dashboard - GreenCharge Visualization and Evaluation Tool</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/js/chart.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightpick@1.3.4/css/lightpick.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">



  <?php
  ini_set('display_errors', 1);
  $countfile = 0;
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if(!empty($_GET["day"]) && isset($_GET["day"]))
  {
    $timeDate = $_GET["day"];
    $day = explode(" ",$timeDate);
    $numberOfSim = $db->getSimulationIds($day);
    //echo "<script>let datePicker = document.getElementById('datePicker');datePicker.value = ".$_GET["day"]."</script>";

  }
 
  if(!empty($_GET["user"]) && isset($_GET["user"]) && !empty($_GET["workingdir"]) && isset($_GET["workingdir"]))
  {
	$csv = array(array());
        $countfile = 0;
        $countrighe = 0;
        $countElem = 0;
        $files = glob("../../users/".$_GET["user"]."/Simulations/".$_GET["workingdir"]."/output/*.csv");
        foreach($files as $file) {
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) {
                  $num = count($data);
                  for ($i=0; $i < $num; $i++) {
                     $axis =  explode(" ", $data[$i]);
                       $csv[$countrighe][0] = $axis[0];
                       $csv[$countrighe][1] = $axis[1];
                       $csv[$countrighe][2] = $countfile;
                       $countrighe++;
                     }
                }
                fclose($handle);
                $countfile++;
            } else {
                echo "Could not open file: " . $file;
            }
        }
        //$resultList = scandir("csv/sim1_1/hcprofiles");
        if(is_dir("../../users/".$_GET["user"]."/Simulations/".$_GET["workingdir"]."/output/HC/"))
          $resultList = array_diff(scandir("../../users/".$_GET["user"]."/Simulations/".$_GET["workingdir"]."/output/HC/"), array('..', '.'));

        if(!empty($_GET["id_hcprofile"]) && isset($_GET["id_hcprofile"])){

          $xaxis = array();
          $yaxis1 = array();
          $yaxis2 = array();
          $yaxis3 = array();
          $path = "../../csv/sim1_1/hcprofiles/hcprofile.csv";
          if (($handle = fopen($path, "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              $num = count($data);
              for ($i=0; $i < $num; $i++) {
                 $axis =  explode(" ", $data[$i]);
                 array_push($xaxis,date("H/i",(int)$axis[0]));
                 array_push($yaxis1,$axis[1]);
                 $sum = $axis[1]+$axis[2];
                 $min = $axis[1]-$axis[2];
                 array_push($yaxis2,$sum);
                 array_push($yaxis3,$min);
              }
          }
          fclose($handle);

        }
          }

        
  }



  if(!empty($_GET["day"]) && isset($_GET["day"]) && !empty($_GET["id_sim"]) && isset($_GET["id_sim"]))
    {
        $path = $db->getpath($_GET["id_sim"]);
        $csv = array(array());
        $countfile = 0;
        $countrighe = 0;
        $countElem = 0;
        $files = glob("../../csv/sim1_1/*.csv");
        foreach($files as $file) {
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) {
                  $num = count($data);
                  for ($i=0; $i < $num; $i++) {
                     $axis =  explode(" ", $data[$i]);
                       $csv[$countrighe][0] = $axis[0];
                       $csv[$countrighe][1] = $axis[1];
                       $csv[$countrighe][2] = $countfile;
                       $countrighe++;
                     }
                }
                fclose($handle);
                $countfile++;
            } else {
                echo "Could not open file: " . $file;
            }
        }
        //$resultList = scandir("csv/sim1_1/hcprofiles");
        if(is_dir("../../csv/sim1_1/hcprofiles/"))
            $resultList = array_diff(scandir("../../csv/sim1_1/hcprofiles/"), array('..', '.'));

        if(!empty($_GET["id_hcprofile"]) && isset($_GET["id_hcprofile"])){

          $xaxis = array();
          $yaxis1 = array();
          $yaxis2 = array();
          $yaxis3 = array();
          $path = "../../csv/sim1_1/hcprofiles/hcprofile.csv";
          if (($handle = fopen($path, "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              $num = count($data);
              for ($i=0; $i < $num; $i++) {
                 $axis =  explode(" ", $data[$i]);
                 array_push($xaxis,date("H/i",(int)$axis[0]));
                 array_push($yaxis1,$axis[1]);
                 $sum = $axis[1]+$axis[2];
                 $min = $axis[1]-$axis[2];
                 array_push($yaxis2,$sum);
                 array_push($yaxis3,$min);
              }
          }
          fclose($handle);

        }
          }

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
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="profile.html"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="table.html"><i class="fas fa-table"></i><span>Table</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="controller.php"><i class="fas fa-tachometer-alt"></i><span>Controller</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>

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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="badge badge-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                        role="menu">
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-envelope fa-fw"></i><span class="badge badge-danger badge-counter">7</span></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                        role="menu">
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">GreenCharge Account</span><img class="border rounded-circle img-profile" src="assets/img/dogs/logo.png"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Dashboard</h3><a class="btn btn-primary btn-sm d-none d-sm-inline-block" onclick="myFunction()" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a></div>
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Provide Simulation Date</span></div>
                                        <div class="form-group">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend"><span class="input-group-text">Date</span></div><input class="form-control" type="text" id="datePicker" />


                                              </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Select Simulation id</span></div>
                                              <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Sim id </button>
                                              <div class="dropdown-menu" role="menu">
                                                  <?php
                                                    if(isset($numberOfSim))
                                                        while ($row = mysqli_fetch_assoc($numberOfSim)) {
                                                  ?>
                                                  <a class="dropdown-item" role="presentation" href="dashboard.php?day=<?php echo $_GET["day"];?>&id_sim=<?php echo $row['id_sim']; ?>"><?php echo $row['id_sim']; ?></a>
                                                  <?php
                                                   }
                                                  ?>
                                                </div>
                                                                                          </div>
                                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>N° OF E.V.'S</span></div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="text-dark font-weight-bold h5 mb-0 mr-3"><span>50%</span></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"><span class="sr-only">50%</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>N° of C.P.'s</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span>18</span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="card shadow mb-4">


                            <div class="card-header d-flex justify-content-between align-items-center">
                                <row>
                                  <h6 class="text-primary font-weight-bold m-0">Corridor Visualization</h6>
                      </div>

                        <div class="card-body">
                          <div class="dropdown"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="filter: blur(0px) brightness(81%) contrast(96%);background-color: rgb(10,108,255);">Select H/C Device</button>
                              <div
                                  class="dropdown-menu" role="menu">

                                  <?php
                                     if(isset($resultList))
                                      foreach ($resultList as $key ) {
                                       ?>
                                       <a class="dropdown-item" role="presentation" href="dashboard.php?id_hcprofile=<?php echo $key ?>&day=<?php echo $_GET["day"];?>&id_sim=<?php echo $_GET['id_sim']; ?>"><?php echo $key ?></a>
                                       <?php
                                        }
                                      ?>



                      </div>

                  </div>
                            <div class="col-md-12"><canvas id="myChart" ></canvas></div>
                          </div>
                                                    <script type="text/javascript">
                                                    // Our labels along the x-axis
                                                    var xaxis = <?php echo json_encode($xaxis);?>;
                                                    // For drawing the lines
                                                    var yaxis = <?php echo json_encode($yaxis1);?>;
                                                    // For drawing the lines
                                                    var yaxis2 = <?php echo json_encode($yaxis2);?>;
                                                    // For drawing the lines
                                                    var yaxis3 = <?php echo json_encode($yaxis3);?>;


                                                    var ctx = document.getElementById("myChart");

                                                    var myLineChart = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                        labels: xaxis,
                                                        datasets: [{
                                                        label: "First Corridor",
                                                        data: yaxis,
                                                        backgroundColor: [
                                                        'rgba(255,255,255, .0)',
                                                        ],
                                                        borderColor: [
                                                        'rgba(210,0,0, .7)',
                                                        ],
                                                        borderWidth: 2
                                                        },
                                                        {
                                                        label: "Middle Corridor",
                                                        data: yaxis2,
                                                        backgroundColor: [
                                                        'rgba(255,255,255, .0)',
                                                        ],
                                                        borderColor: [
                                                        'rgba(46,232,0, .7)',
                                                        ],
                                                        borderWidth: 2
                                                        },
                                                        {
                                                        label: "Second Corridor",
                                                        data: yaxis3,
                                                        backgroundColor: [
                                                        'rgba(255,255,255, .0)',
                                                        ],
                                                        borderColor: [
                                                        'rgba(10,108,255, .7)',
                                                        ],
                                                        borderWidth: 2
                                                        }
                                                        ]
                                                        },
                                                        options: {
                                                        responsive: true
                                                        }
                                                        });




                                                      </script>



                        </div>
                    </div>

                <div class="col-lg-5 col-xl-4">
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="text-primary font-weight-bold m-0">Self-Consumption</h6>
                            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"
                                    role="menu">
                                    <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" role="presentation" href="#">&nbsp;Action</a><a class="dropdown-item" role="presentation" href="#">&nbsp;Another action</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="#">&nbsp;Something else here</a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area"><canvas data-bs-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Self-Consumption&quot;,&quot;Grid-Consumption&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;50&quot;,&quot;50&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{}}}"></canvas></div>
                            <div
                                class="text-center small mt-4"><span class="mr-2"><i class="fas fa-circle text-primary"></i>&nbsp;Self-Consumption</span><span class="mr-2"><i class="fas fa-circle text-success"></i>&nbsp;Grid-Consumption</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">Cumulative Energy</h6>
                    </div>
                    <div class="card-body">
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                         <script type="text/javascript">
                           google.charts.load('current', {'packages':['corechart']});
                           google.charts.setOnLoadCallback(drawChart);

                           function drawChart() {
                             var axe = <?php echo json_encode($csv);?>;
                             var numfile = <?php echo json_encode($countfile);?>;
                             var date = new Date(axe[0][0] * 1000);
                             date.setHours(0);
                             date.setMinutes(0);
                             date.setSeconds(0);

                             var median = new Array(numfile).fill(0);

                             var values = new Array(numfile).fill(1);
                             var finalValue = new Array(144)
                             var i;
                             Number.prototype.integer = function () {
                                  return Math[this < 0 ? 'ceil' : 'floor'](this);
                              }
                             var delta = (date.getTime()/1000);
                             for (i =0; i<144; i++){
                               axe.forEach(element => {

                                      if(i*600<(element[0]-delta) && (i+1)*600 > (element[0]-delta)){
                                            median[element[2]+1] = parseFloat(median[element[2]+1]) + parseFloat(element[1]);
                                            values[element[2]]++;
                                      }

                                  });



                                  var date2=new Date(i*600 * 1000);

                                  median[0] = date2.getHours() + ':' + date2.getMinutes()
                                  for(j=0; j<numfile;j++){
                                      median[j+1] = Math.round(median[j+1]/values[j]);
                                      median[j+1].integer();

                                  }
                                  finalValue[i+1] = median.slice();
                                  median.fill(0);
                                  values.fill(1);


                             }
                             var j;


                             for (j =1; j<numfile; j++){
                                  for(i = 143; i>1;i--){

                                      finalValue[i+1][j] = 3600*((parseFloat(finalValue[i+1][j]) - parseFloat(finalValue[i][j]))/600);
                                      if(finalValue[i+1][j]<0) finalValue[i+1][j]=0;
                                    }
                                    finalValue[1][j] = 0;
                                 }





                             var labels = new Array(numfile);
                             labels[0] = 'Hour'
                             for(i=0; i<numfile;i++){
                                  labels[i+1] = "Csv n°"+(i+1);
                             }

                            finalValue[0] = labels.slice();

                             var data = google.visualization.arrayToDataTable(finalValue);

                             var options_fullStacked = {
                               title: 'Cumulative Energy',
                               hAxis: {title: 'Hour',  titleTextStyle: {color: '#36b9cc'}},
                                 isStacked: true,
                                 height: 350,
                                 colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],

                                 legend: {position: 'top', maxLines: 3},
                                 vAxis: {
                                   title: 'KW',titleTextStyle: {color: '#e74a3b'},
                                   minValue: 0,
                                 }
                               };

                             var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                             chart.draw(data, options_fullStacked);
                           }
                         </script>
                            <div id="chart_div" style="height: 370px; width: 100%;"></div>

                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">Todo List</h6>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">10:30 AM</span></div>
                                <div class="col-auto">
                                    <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" id="formCheck-1"><label class="custom-control-label" for="formCheck-1"></label></div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">11:30 AM</span></div>
                                <div class="col-auto">
                                    <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" id="formCheck-2"><label class="custom-control-label" for="formCheck-2"></label></div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">12:30 AM</span></div>
                                <div class="col-auto">
                                    <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" id="formCheck-3"><label class="custom-control-label" for="formCheck-3"></label></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <p class="m-0">Primary</p>
                                <p class="text-white-50 small m-0">#4e73df</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <p class="m-0">Success</p>
                                <p class="text-white-50 small m-0" style="color: rgb(5,126,39);">#1cc88a</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-info shadow">
                            <div class="card-body">
                                <p class="m-0">Info</p>
                                <p class="text-white-50 small m-0">#36b9cc</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-warning shadow">
                            <div class="card-body">
                                <p class="m-0">Warning</p>
                                <p class="text-white-50 small m-0">#f6c23e</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <p class="m-0">Danger</p>
                                <p class="text-white-50 small m-0">#e74a3b</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-secondary shadow">
                            <div class="card-body">
                                <p class="m-0">Secondary</p>
                                <p class="text-white-50 small m-0">#858796</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/greencharge.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
