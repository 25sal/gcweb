var request_timer= null;

function loadView(json, view)
{

  $( "#"+view ).prepend(prettyPrintJson.toHtml(json)+'<hr>'); // riquadro sotto al pulsante
 }

  function sendResponse(jsonRequest) {

    var url = adaptor_address+"/postanswer";
    var form = new FormData();
    var jsonResponse = {}
    jsonResponse["sim_id"]=jsonRequest.sim_id;
    jsonResponse["time"]=""+(parseInt(jsonRequest.time)+10);
    jsonResponse["id"]=jsonRequest.message.id;



    switchSubject = jsonRequest.message.subject;
    if(switchSubject == 'LOAD'){

      jsonResponse["subject"]= "ASSIGNED_START_TIME";
      jsonResponse["ast"]= jsonRequest.message.est.trim(); //+ 7200 per sincronizzarlo con l'orario italiano
      //jsonResponse["producer"]= "[0]:[0]";
      form.append("response",JSON.stringify(jsonResponse));
      $.ajax({
        url: url,
        type: 'POST',
        data: form,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {$.notify("Post Response Sent");},
        error: function(){
           $.notify("Post Response Failed");
                       }
              });

           }
    else if(switchSubject == 'HC'){
      jsonResponse["thefile"]= jsonRequest.message.id+".csv";  
      jsonResponse["subject"]= "HC_PROFILE"; // --> quando si preme invia-----impotare controllo SE IL FILE è STATO INSERITO---------- ANCHE PER ALTRI DATI
      form.append("response",JSON.stringify(jsonResponse));
      var csvresponse="";
      Papa.parse(jsonRequest.message.profile, {
                                           download:true,
					   delimiter: ' ',
					   step: function (result, parsers) {
						csvresponse+=result.data[0]+ " " + result.data[1] + "\n";
                                                 //console.log("Row data:"+ result.data);
						//console.log("Error:"+ result.error);
						
						},
                                           complete: function(result,file){
							console.log("complete");
							
							var b =new Blob([csvresponse]);
							form.append('thefile',b ,'test.csv');
					  $.ajax({
    							type: 'POST',
    							url: url,
    							data: form,
    							processData: false,
    							contentType: false
							}).done(function(data) {
       							console.log(data);$.notify("HC Profile Uploaded");
							});
							}
					});

    }
   
     else if(switchSubject == 'EV'){
	jsonResponse["subject"]= "EV_PROFILE";
        form.append("response",JSON.stringify(jsonResponse));

      var booked_charge = parseInt(jsonRequest.message.capacity)*(parseInt(jsonRequest.message.target_soc)-parseInt(jsonRequest.message.soc_at_arrival))/100;
          var available_energy= parseInt(jsonRequest.message.max_ch_pow_ac)*(parseInt(jsonRequest.message.planned_departure_time)-parseInt(jsonRequest.message.arrival_time))/3600;
          var charged_energy= available_energy;
          var charged_0 =parseInt(jsonRequest.message.capacity)*parseInt(jsonRequest.message.soc_at_arrival)/100;
          if(available_energy>=booked_charge)
             charged_energy = booked_charge;
          var charging_time = 3600*charged_energy/parseInt(jsonRequest.message.max_ch_pow_ac);
          var csvstr = parseInt(jsonRequest.message.arrival_time)+","+ charged_0+"\n";
          csvstr += (charging_time+parseInt(jsonRequest.message.arrival_time))+","+(charged_energy+charged_0);
          console.log(csvstr);
          var b =new Blob([csvstr]);
          form.append('thefile',b ,'test.csv');
 
	  $.ajax({
                  type: 'POST',
                  url: url,
                  data: form,
                  processData: false,
                  contentType: false
                  }).done(function(data) {
              console.log(data);$.notify("EV Profile Uploaded");
                           });
                      
              


    } 
     loadView(jsonResponse,"responseView");


      }

function ajaxRestRequest() {
    var    url = adaptor_address+"/getmessage";
    //jQuery.support.cors = true;
    $.ajax({
      url: url,
      type: 'GET',
      dataType: "json",
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      success: function(data, textStatus, jqXHR ) {
        //console.log(data); // visualizzare la sorgente
        //console.log(textStatus); // mostra il success
        //console.log(jqXHR); // da qui tramite punto mi richiamo le informazioni dell'header( da vedere nei vari campi)
        //console.log("header: ",jqXHR.getAllResponseHeaders()); ----------headeer da aggiungere
        //console.log("textStatus: ",textStatus);------------headeer da aggiungere

        var jsonResultString = JSON.stringify(data);
        var jsonResult = JSON.parse(jsonResultString);
        loadView(jsonResult,"requestsView");
        var subject = jsonResult.message.subject;
        if(subject=='LOAD' || subject=='HC' || subject=="EV")
	  sendResponse(jsonResult);

      },
      error: function(){
        $.notify("HTTP Request failed");
      }
    });
  }

function doOnLoad() {
window.dhx4.skin = 'dhx_web';
var main_layout = new dhtmlXLayoutObject(document.body, '2E');

var top = main_layout.cells('a');
top.setText('REST Scheduler');
var str = [
    { type:"input" , inputWidth:250, name:"geturl", label:"Request Interface", value: adaptor_address+"/getmessage", readonly:true  },
    { type:"input" , inputWidth:250, name:"posturl", label:"Response Interface", value:adaptor_address+"/postanswer", readonly:true  },
    { type:"button" , name:"start_button", value:"start", inputLeft:400, inputTop:10, position:"absolute"  },
    { type:"button" , name:"stop_button", value:"stop", inputLeft:400, inputTop:40, position:"absolute"  }
];
var controlform = top.attachForm(str);

controlform.attachEvent('onButtonClick', function(name, command){
    if(name=="start_button")
    {
        if(request_timer==null)
         request_timer=setInterval(ajaxRestRequest,4000);

    }
    else if(name=="stop_button") {
          clearInterval(request_timer);
          request_timer=null;
	}
   
});




var bottom = main_layout.cells('b');
var layout_1 = bottom.attachLayout('2U');

var request_cell = layout_1.cells('a');
request_cell.setText('Requests');
request_cell.attachURL('./data/requests.html', true);


var response_cell = layout_1.cells('b');
response_cell.setText('Responses');
response_cell.attachURL('./data/responses.html', true);
}

