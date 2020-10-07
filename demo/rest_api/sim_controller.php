<?php
  require './vendor/autoload.php';
  use Supervisor\Supervisor;
  use Supervisor\Connector\XmlRpc;
  use fXmlRpc\Client;
  use fXmlRpc\Transport\HttpAdapterTransport;
  use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
  use \Http\Message\MessageFactory\DiactorosMessageFactory as MessageFactory;

  include '../config.php';
  //Create GuzzleHttp client
  $guzzleClient = new \GuzzleHttp\Client(['auth' => [$supervisor_user, $supervisor_pass]]);

  // Pass the url and the guzzle client to the XmlRpc Client
  $client = new Client(
      $supervisor_address,
      new HttpAdapterTransport(
          new MessageFactory(),
          new GuzzleAdapter($guzzleClient))
  );

  // Pass the client to the connector
  // See the full list of connectors bellow
  $connector = new XmlRpc($client);

  $supervisor = new Supervisor($connector);
  $msg = "-1";
  // returns Process object
  error_log("get:".$_POST["action"]);
  if(!empty($_POST["action"]) && isset($_POST["action"]))
  {
    if($_POST["action"] == "start"){
      try { 
      $supervisor->startProcess($_POST['process'],true);
        } catch (Exception $e) {
          error_log('Caught exception: ',  $e->getMessage(), "\n");
        }
      $msg = "2";
    }
    elseif ($_POST["action"] == "stop") {
      try {      
      $supervisor->stopProcess($_POST['process']);
    } catch (Exception $e) {
      error_log('Caught exception: ',  $e->getMessage(), "\n");
  }
      $msg = "0";
    }
    elseif ( $_POST["action"] == "status") {
      $process = $supervisor->getProcess($_POST['process']);
       error_log($process->isRunning());
       if($process->isRunning()){
	             $msg='1';
	       }
	      else{
		           $msg='0';
	            }
 

          }
          echo $msg;
  }
   else
       echo $msg;

?>
