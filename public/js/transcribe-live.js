/*===========================================================================
*
*  LIVE TRANSCRIBE COUNTDOWN TIMER
*
*============================================================================*/
var time_limit; 
var clock;

$.ajax({
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
  },
  type: "GET",
  url: 'settings',

}).done(function(data) {

    time_limit = data['length_live'];

    clock = $(".countdown").FlipClock(0, {
      countdown: true,
      clockFace: 'HourCounter',
      autoStart: false,
      callbacks: {
                stop: function() {
                  terminateRecording();     
                  stopClock();              
                  clock.setTime(time_limit*60);                  
                }
              }
    });  

    clock.setTime(time_limit*60);
    
});



/*===========================================================================
*
*  02 - LIVE TRANSCRIBE ACTION BUTTON
*
*============================================================================*/
var seconds;
var initiate;
var refreshInterval;
var limit;

$(document).ready(function(){

  "use strict";

  /* -------------------------------------------- */
  /*    TOGGLE START/STOP BUTTON
  /* -------------------------------------------- */
  $("#start").on("click", function(e){

      "use strict";

      e.preventDefault();

      if ($(this).hasClass('play')) {

          if (limit < 1) {
            $('#error').show().slideDown()
              var message = '<span>Not enough balance. Subscribe or Top up</span>';
              $('#error').show().slideDown()
                .html(message)
                .delay(8000)
                .slideUp();
                clock.stop();
              $("#transcribe-audio-format").slideUp();
              $('#start').removeClass('stop').addClass('play').html('<i class="fa fa-microphone"></i>Start');
              clock.setTime(time_limit*60);

          } else {
            $('textarea').val('');

            $("#transcribe-audio-format").slideDown();

            initiateRecording();

            clock.start();          

            $(this).removeClass('play').addClass('stop').html('<i class="fa fa-stop-circle"></i>Stop');
          }
          
      
      } else if ($(this).hasClass('stop')) {

          terminateRecording();

          $("#transcribe-audio-format").slideUp();

          clock.stop();

          clock.setTime(time_limit*60);

          $(this).removeClass('stop').addClass('play').html('<i class="fa fa-microphone"></i>Start');

          limits();

      } 

  });

});


/* -------------------------------------------- */
/*    CALL WEBSOCKET.JS FUNCTIONS
/* -------------------------------------------- */

function initiateRecording() {
    
    "use strict";

    var language = $('#languages').find(':selected').attr('data-code');

    setLanguage(language);
    startSeconds();
    startLiveRecording();    

}

function terminateRecording() {

    "use strict";

    stopLiveRecording();  
    

}

function stopClock() {      
    
    "use strict";

    stopSeconds();
    if (seconds != 0) {
      recordResults();
    }        
    limits();
    $("#transcribe-audio-format").slideUp();
    $('#start').removeClass('stop').addClass('play').html('<i class="fa fa-microphone"></i>Start');
    clock.setTime(time_limit*60);
}

function stopClockError() {      
    
  "use strict";

  clock.stop();
  stopSeconds();
  $("#transcribe-audio-format").slideUp();
  $('#start').removeClass('stop').addClass('play').html('<i class="fa fa-microphone"></i>Start');
  clock.setTime(time_limit*60);
}

function startSeconds() {
  "use strict";
  seconds = 0;
  refreshInterval = setInterval(() => {
    ++seconds;
  }, 1000);
  
}

function stopSeconds() {
  "use strict";
  clearInterval(refreshInterval);
}

function recordResults() {

  "use strict";

  var form = document.getElementById("live-transcribe-form");
  var text = document.getElementById("transcript").value;
  var formData = new FormData(document.getElementById("live-transcribe-form"));
  formData.append("audiolength", seconds);
  formData.append("text", text);

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
     type: "POST",
     url: $(form).attr('action'),
     data: formData,
     contentType: false,
     processData: false,
     cache: false,
     success: function(response) { },
     error: function (response) 
      {
        seconds = 0; 

        if (response.responseJSON['error']) {
          $('#notificationModal').modal('show');
          $('#notificationMessage').text(response.responseJSON['error']);
        }
      }

   }).done(function(response) {
        $("#resultTable").DataTable().ajax.reload(); 
        seconds = 0;              
   })
}

function limits() {

  "use strict";

  $.ajax({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    type: "GET",
    url: 'settings/live/limits',
  }).done(function(data) {   
      limit = parseFloat(data['limits']);
  });
}

