var simulator_process;





function update_status(status)
{
	var $start = $('#start');
    var $stop = $('#stop');
	  var $status = $('#status');
  if(status == 0)
  {
    $status.addClass("statusdisabled");
    $status.removeClass("statusenabled");  
    $start.addClass("startenabled");
	$start.removeClass("startdisabled");
	$stop.addClass("stopdisabled");
	$stop.removeClass("stopenabled");
	$stop.attr('disabled', true);
	$start.attr('disabled', false);
  }
  else if (status ==1)
  {
	$status.addClass("statusenabled");
	$status.removeClass("statusdisabled");  
	$start.addClass("startdisabled");
	$start.removeClass("startenabled");
    $stop.addClass("stopenabled");
	$stop.removeClass("stopdisabled");
	$stop.attr('disabled', false);
	$start.attr('disabled', true);
  }

}




function sim_controller(fd)
{
	
	$.ajax({
		url: 'rest_api/sim_controller.php',
		type: 'post',
		data: fd,
		contentType: false,
		processData: false,
		success: function(response){
			if(response == 2){
			   alert("simulation started ");
			}
			else if(response == 0){
				alert("simulation stopped " );
			}
			else
			alert("simulation error " );
		},
	});
}

function start_simulator( ids){

    var fd = new FormData();
    fd.append('action', 'start');
	fd.append('process', simulator_process);
	sim_controller(fd);

}

function pause_simulation(){



}


function stop_simulator(){
	var fd = new FormData();
    fd.append('action', 'stop');
    fd.append('process', simulator_process);
	sim_controller(fd);

}

function simulation_status(indicator)
{
	var fd = new FormData();
    fd.append('action', 'status');
	fd.append('process', simulator_process);
	
	$.ajax({
		url: 'rest_api/sim_controller.php',
		type: 'post',
		data: fd,
		contentType: false,
		processData: false,
		success: function(response){
			console.log("response: "+response);
			

				update_status(response);
			
		},
	});

}
