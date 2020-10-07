var BOSH_SERVICE = 'http://parsec2.unicampania.it:5280/http-bind';
var connection = null;
var messages = [];
var auto = 1;
var post_url="http://parsec2.unicampania.it:"+http_post_port+"/postanswer";
var devices ={};
// ok
function autoresponse()
{
	if(auto==1)
	  auto=0;
	  else
	    auto=1;
}

$(document).ready(function() {  // clic per cambiare i messaggi


	$(".custom-file-input").on("change", function() {
	  var fileName = $(this).val().split("\\").pop();
	  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
	// fine gestione file
  
	$( "#sendResponse" ).click(function() { // click sul modalResponse
	  sendResponse();
	});
  
  connection = new Strophe.Connection(BOSH_SERVICE);
  
	  // Uncomment the following lines to spy on the wire traffic.
	  //connection.rawInput = function (data) { log('RECV: ' + data); };
	  //connection.rawOutput = function (data) { log('SEND: ' + data); };
  
	  // Uncomment the following line to see all the debug output.
	  //Strophe.log = function (level, msg) { log('LOG: ' + msg); };
  
  
	  $('#connect').bind('click', function () {
	  var button = $('#connect').get(0);
	  if (button.value == 'connect') {
		  button.value = 'disconnect';
  
		  connection.connect($('#jid').get(0).value,
					 $('#pass').get(0).value,
					 onConnect);
	  } else {
		  button.value = 'connect';
		  connection.disconnect();
	  }
	  });
  
});



function log(msg)
{
	$('#log').append('<div></div>').append(document.createTextNode(msg));
}

function log(msg, msgid) 
{
	$('#log').append('<div><table width="900"><td width="800">').append(document.createTextNode(msg)).append('</td>');
	var respond='';
	

	if(msgid!=null)
	{
	 var elems = messages[msgid].getElementsByTagName('body');
	 var body = Strophe.getText(elems[0]);
	 body = body.replace(/\s+/g, ' ');
	if(body.startsWith("LOAD")){
	   if(auto==0)
	 	{   respond = "AST.html"
			$('#log').append('<td><div class="col-md-6"> <button onclick="loadview('+msgid+')" class="btn btn-primary" type="button" id="loadview"  data-toggle="modal" data-target="#modalResponse">RESPONSE</button></div>');    
	    	$('#log').append('</td></tr></table></div>');
		}
		else
		{
			$('#log').append('<td></td></tr></table></div>');
			var msg  = messages[msgid];
			var tokens = body.split(' ');
			var from = msg.getAttribute('from');
			var to = msg.getAttribute('to');
			var response = "";
			var ast =parseInt(tokens[6]) + 600;
			response = "ASSIGNED_START_TIME " + tokens[1] + " " + tokens[2] + " " + ast  ;
			
			var reply = $msg({to: from, from: to, type: 'chat'}).c("body").t(response);
			connection.send(reply.tree());
			log("sent response:" + response);
		
	  		
		}

		 }
          else if (body.startsWith("HC")){

                if(auto!=0)
			{
	
				var tokens = body.split(' ');
				var csvresponse="";
				jsonResponse = {}
          			jsonResponse["subject"]= "HC_PROFILE";

          			//jsonResponse["sim_id"]=jsonRequest.sim_id;
          			jsonResponse["time"]=tokens[4];
          			jsonResponse["id"]=tokens[1];
				Papa.parse(tokens[3], {
                                           download:true,
					   delimiter: ' ',
					   step: function (result, parsers) {
						if(result.data.length==3)
						csvresponse+=result.data[0]+ " " + result.data[1] + "\n";
                                                 //console.log("Row data:"+ result.data);
						//console.log("Error:"+ result.error);
						
						},
                                           complete: function(result,file){
							console.log("complete");
							
							var b =new Blob([csvresponse]);
							var fd = new FormData();
							fd.append('thefile',b ,'test.csv');
							fd.append('response', JSON.stringify(jsonResponse));
							$.ajax({
    							type: 'POST',
    							url: post_url,
    							data: fd,
    							processData: false,
    							contentType: false
							}).done(function(data) {
       							console.log(data);
							});
							}
					});
			
				}
		}
        else if(body.startsWith("CREATE_EV "))
	{
	   var tokens = body.split(' ');
	   var ev_id = tokens[1];
	   var capacity = parseInt(tokens[2]);
	   var max_ch_pow_ac = parseFloat(tokens[3]);
	   devices[ev_id] = {"capacity": capacity, "max_ch_pow_ac": max_ch_pow_ac};
	} 
	else if(body.startsWith("EV "))
	  if(auto!=0)
		{
		var tokens = body.split(' ');
                var csvresponse="";
		var ev_id = tokens[1];
		var capacity = devices[ev_id]["capacity"];
		var max_ch_pow_ac = devices[ev_id]["max_ch_pow_ac"];
		var dep_time = parseInt(tokens[3]);
		var arr_time = parseInt(tokens[4]);
		var target_soc = parseInt(tokens[7]);
		var arriv_soc = parseInt(tokens[2]);
		var sim_time = parseInt(tokens[8]);
               if(sim_time==dep_time){

		var booked_charge = capacity*(target_soc-arriv_soc)/100;
          var available_energy= max_ch_pow_ac*(dep_time-arr_time)/3600;
          var charged_energy= available_energy;
          var charged_0 =capacity*arriv_soc/100;
          if(available_energy>=booked_charge)
             charged_energy = booked_charge;
          var charging_time = 3600*charged_energy/max_ch_pow_ac;
          var csvstr = arr_time+","+ charged_0+"\n";
          csvstr += (charging_time+arr_time)+","+(charged_energy+charged_0);
          console.log(csvstr);
	  var form = new FormData();
          var b =new Blob([csvstr]);
	  jsonResponse = {}
	  jsonResponse["subject"]= "EV_PROFILE";

    	  //jsonResponse["sim_id"]=jsonRequest.sim_id;
          jsonResponse["time"]=tokens[27];
          jsonResponse["id"]=tokens[2];
	  form.append("response", JSON.stringify(jsonResponse));
	  form.append('thefile',b ,'test.csv');

          $.ajax({
                  type: 'POST',
                  url: post_url,
                  data: form,
                  processData: false,
                  contentType: false
                  }).done(function(data) {
              console.log(data);$.notify("EV Profile Uploaded");
	      log("EV_PROFILE sent");
                           });


    		  }

		}//msg!=null	
		}
		 return true;
	}



function loadview(msgid)
{
	var elems = messages[msgid].getElementsByTagName('body');
	 var body = Strophe.getText(elems[0]);
	var tokens = body.split(' ');
    if(tokens[0] == 'LOAD')
      {
		
		$("#msgid").val(msgid);
        $("#resp_id").text("Response: "+ tokens[0]); // scritta sul modal
        $("#div_ast").show();
        $("#div_producer").show();
        //$("#getMessage").attr("disabled", true);
        //$("#showResponse").removeAttr("disabled"); //attr("disabled", false);
        //$("#sim_id").val(json.sim_id);
        $("#m_subject").val("ASSIGNED_START_TIME");
        
		$("#m_id").val(tokens[2]);
		$("#m_ast").val(tokens[6]);
        $("#m_producer").val("[0]:[0]");
        $("#div_profile").hide();
        $("#div_version").hide();
        $('#div_ast').datetimepicker(
          {
            date: moment(tokens[6]*1000),
            minDate: moment(tokens[6]*1000),
            maxDate: moment(tokens[8]*1000),
            format: "DD/MM/YYYY HH:mm",
          });
          $('#div_time').datetimepicker(
            {
              date: moment(tokens[6]*1000),
              minDate: moment(tokens[6]*1000),
              format: "DD/MM/YYYY HH:mm",
            });
          }else if(tokens[0]== 'HC_LOAD')
          {/*
            $("#resp_id").text("Response: "+ jsonMessage.subject); // scritta sul modal
            $("#getMessage").attr("disabled", true);
            $("#showResponse").attr("disabled", false);
            $("#sim_id").val(json.sim_id);
            $("#m_subject").val(jsonMessage.subject);
            $("#m_id").val(jsonMessage.id);
            $("#m_version").val("10");
            $("#div_profile").show();
            $("#div_version").show();
            $("#div_ast").hide();
            $("#div_producer").hide();
            $('#div_time').datetimepicker(
              {
                date: moment(json.time*1000), //*1000 per orario del server in secondi
                minDate: moment(json.time*1000),
                format: "DD/MM/YYYY HH:mm",
			  });
			  */
            }
          }



function onConnect(status)
{
    if (status == Strophe.Status.CONNECTING) {
	log('Strophe is connecting.');
    } else if (status == Strophe.Status.CONNFAIL) {
	log('Strophe failed to connect.');
	$('#connect').get(0).value = 'connect';
    } else if (status == Strophe.Status.DISCONNECTING) {
	log('Strophe is disconnecting.');
    } else if (status == Strophe.Status.DISCONNECTED) {
	log('Strophe is disconnected.');
	$('#connect').get(0).value = 'connect';
    } else if (status == Strophe.Status.CONNECTED) {
	log('Strophe is connected.');
	//log('ECHOBOT: Send a message to ' + connection.jid +  to talk to me.');

	connection.addHandler(onMessage, null, 'message', null, null,  null); 
	connection.send($pres().tree());
    }
}

function onMessage(msg) {
    var to = msg.getAttribute('to');
    var from = msg.getAttribute('from');
    var type = msg.getAttribute('type');
    var elems = msg.getElementsByTagName('body');

    if (type == "chat" && elems.length > 0) {
	var body = elems[0];

	var messagebody =  Strophe.getText(body);

	messages.push(msg);
	console.log('Message from ' + from + ': ' + Strophe.getText(body));
	log('Message from ' + from + ': ' + Strophe.getText(body),messages.length-1);
    
	/*var reply = $msg({to: from, from: to, type: 'chat'})
            .cnode(Strophe.copyElement(body));
	connection.send(reply.tree());

	log('ECHOBOT: I sent ' + from + ': ' + Strophe.getText(body));*/



    }

    // we must return true to keep the handler alive.  
    // returning false would remove it after it finishes.
    return true;
}



function sendResponse()
{
	var msg  = messages[$("#msgid").val()];
	var from = msg.getAttribute('from');
	var to = msg.getAttribute('to');
	var response = "";
	var elems = msg.getElementsByTagName('body');
	var body = Strophe.getText(elems[0]);
	var tokens = body.split(' ');
    if(tokens[0] == 'LOAD')
      {
		  response = "ASSIGNED_START_TIME " + tokens[2] + " " + tokens[4] + " " + ($('#div_ast').datetimepicker('viewDate').unix()+7200) + " " + $("#m_producer").val();
		log("response:" + response);
		var reply = $msg({to: from, from: to, type: 'chat'})
			.c("body").t(response);
		connection.send(reply.tree());
	  }
}




  
