$(document).ready(function() {  // clic per cambiare i messaggi

  var num = 0 ;
  // questa parte di codice serve per far visualizzare il nome del file scelto
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
  // fine gestione file
  var switchSubject;
  $( "#getMessage" ).click(function() {
    ajaxRestRequest();
  });

  $( "#sendResponse" ).click(function() { // click sul modalResponse
    ajaxRestSend();
  });

  // per inviare i dati con il tasto invia nel Modal
  function ajaxRestSend() {
    // questi 3 sotto sono di prova( senza invio al server)
    // $("#getMessage").removeAttr("disabled"); //attr("disabled", false);  per riabilitare un pulsante disabilitato
    // $("#showResponse").attr("disabled", true); // sisabilita un bottone
    // $("#modalResponse").modal('toggle'); //abilitazione manuale del modal

    // //in attesa del server di risposta---------------------------------------------------------
    var url = adaptor_address+"/postanswer";
    var form = new FormData();
    form.append("sim_id", $("#sim_id").val());
    form.append("time", ($('#div_time').datetimepicker('viewDate').unix()+7200));//+ 7200 per sincronizzarlo con l'orario italiano
    form.append("id", $("#m_id").val());
    form.append("subject", $("#m_subject").val());
    /*var sim_id=$("#sim_id").val();
    var time = $("#div_time").val();
    var subject = $("m_subject").val();
    var id = $("m_id").val();*/
    if(switchSubject == 'LOAD'){
      /*  var ast = $("div_ast").val();
      var producer = $("m_producer").val();*/
      form.append("ast", ($('#div_ast').datetimepicker('viewDate').unix()+7200)); //+ 7200 per sincronizzarlo con l'orario italiano
      form.append("producer", $("#m_producer").val());
      //var data = "sim_id="+sim_id+"&time="+time+"&subject="+subject+"&id="+id+"&ast="+ast+"&producer="+producer;
    }
    else if(switchSubject == 'HC_LOAD'){
      /*var version = $("div_version").val();
      var profile = $("div_profile").prop('files');*/
      form.append("version", $("#m_version").val());
      form.append("profile", $("#m_profile")[0].files[0]); // --> quando si preme invia-----impotare controllo SE IL FILE è STATO INSERITO---------- ANCHE PER ALTRI DATI
      //  var data = "sim_id="+sim_id+"&time="+time+"&subject="+subject+"&id="+id+"&version="+version+"&profile="+profile;
    }
    for (var pair of form.entries()) {
      console.log(pair[0]+ ', ' + pair[1]);
    }
    $.ajax({
      url: url,
      type: 'POST',
      data: form,
      processData: false,
      success: function(data, textStatus, jqXHR) {
        console.log(data); // visualizzare la sorgente
        $("#getMessage").removeAttr("disabled"); //attr("disabled", false);  per riabilitare un pulsante disabilitato
        $("#showResponse").attr("disabled", true); // sisabilita un bottone
        $("#modalResponse").modal('toggle'); //abilitazione manuale del modal
        var jsonResultString = JSON.stringify(data);
        var jsonResult = JSON.parse(jsonResultString);
        loadView(jsonResult);
      },
      error: function(){
        alert("Invio al server fallito!!!");
      }
    });
      }
    // per prendere i dati dal sito e visualizzarli sull'interfaccia
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
          loadView(jsonResult);
        },
        error: function(){
          alert("Chiamata al server fallita!");
        }
      });
    }
    function loadView(json)
    {
      num++;
      var jsonRequest = JSON.stringify(json); //  per l'intero codice sito
      var jsonMessageString = JSON.stringify(json.message);
      var jsonMessage = JSON.parse(jsonMessageString);

      switchSubject = jsonMessage.subject;
      //$( "#getResults" ).html("<pre>"+JSON.stringify(json,undefined, 2) +"</pre>"); // riquadro sotto al pulsante
      //$( "#postResults" ).html("<pre>"+JSON.stringify(json,undefined, 2) +"</pre>"); // riquadro sotto al pulsante
      $( "#getResults" ).html('<strong>'+prettyPrintJson.toHtml(json)+'</strong>'); // riquadro sotto al pulsante
      $( "#postResults" ).html('<strong>'+prettyPrintJson.toHtml(json)+'</strong>'); // riquadro sotto al pulsante

      // costruzione tabella------------------------------------
      // scrollbar che scende in automatico - non va, rivedere
      // var position = 250;
      // $("table-responsive").scrollTop(position);

      var sim_id = json.sim_id;
      var time = json.time;
      var subject = json.message.subject
      var id = json.message.id
      var markup = "<tr><td><strong>" + (num) +"</strong></td><td>" + sim_id + "</td><td>" + time + "</td><td>" + subject + "</td><td>" + id + "</td></tr>";
      $("#json_table").append(markup);
      // fine costruzione tabella-------------------------------------

      if(jsonMessage.subject == 'LOAD')
      {
        $("#resp_id").text("Response: "+ jsonMessage.subject); // scritta sul modal
        $("#div_ast").show();
        $("#div_producer").show();
        $("#getMessage").attr("disabled", true);
        $("#showResponse").removeAttr("disabled"); //attr("disabled", false);
        $("#sim_id").val(json.sim_id);
        $("#m_subject").val(jsonMessage.subject);
        $("#m_ast").val(jsonMessage.est);
        $("#m_id").val(jsonMessage.id);
        $("#m_producer").val("[0]:[0]");
        $("#div_profile").hide();
        $("#div_version").hide();
        $('#div_ast').datetimepicker(
          {
            date: moment(jsonMessage.est*1000),
            minDate: moment(jsonMessage.est*1000),
            maxDate: moment(jsonMessage.lft*1000),
            format: "DD/MM/YYYY HH:mm",
          });
          $('#div_time').datetimepicker(
            {
              date: moment(json.time*1000),
              minDate: moment(json.time*1000),
              format: "DD/MM/YYYY HH:mm",
            });
          }else if(jsonMessage.subject == 'HC_LOAD')
          {
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
            }
          }
        });
