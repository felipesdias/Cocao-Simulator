<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Cocão Simulator</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.1/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.1/js/materialize.min.js"></script>

  </head>
  <body>
    <div class="container" style="display: none">
      <div class="row">
        <nav>
          <div class="nav-wrapper">
            <div class="col s12">
              <a href="#" class="brand-logo">Text to speech example</a>
            </div>
          </div>
        </nav>
      </div>
      <form class="col s8 offset-s2">
        <div class="row">
          <label>Choose voice</label>
          <select id="voices"></select>
        </div>
        <div class="row">
          <div class="col s6">
            <label>Rate</label>
            <p class="range-field">
              <input type="range" id="rate" min="1" max="100" value="10" />
            </p>
          </div>
          <div class="col s6">
            <label>Pitch</label>
            <p class="range-field">
              <input type="range" id="pitch" min="0" max="2" value="1" />
            </p>
          </div>
          <div class="col s12">
            <p>N.B. Rate and Pitch only work with native voice.</p>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="message" class="materialize-textarea"></textarea>
            <label>Write message</label>
          </div>
        </div>
      </form>  
    </div>

    <a href="#" id="speak" class="waves-effect waves-light btn">Speak</a>

    <div id="modal1" class="modal">
      <h4>Algo de errado não esta certo</h4>
      <p>Seu navegador ta lixoso.</p>
      <p>Tenta o Google Chrome</p>
      <div class="action-bar">
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
      </div>
    </div>
  </body>
</html>






<script>
$(function(){
  var voice_id = -1
  if ('speechSynthesis' in window) {
    speechSynthesis.onvoiceschanged = function() {
      var $voicelist = $('#voices');

     
      if($voicelist.find('option').length == 0) {
        speechSynthesis.getVoices().forEach(function(voice, index) {
          var $option = $('<option>')
          .val(index)
          .html(voice.name + (voice.default ? ' (default)' :''));
          if(voice.name.toLowerCase().split("google").length > 1 && (voice.name.toLowerCase().split("brasil").length > 1 || voice.name.toLowerCase().split("brazil").length > 1)) {
            voice_id = index;
          }
          console.log(voice.name)
          $voicelist.append($option);
        });

        $voicelist.material_select();
      }
      if(voice_id === -1)
    	$('#modal1').openModal();
    }

    $('#speak').click(function(){
    $.ajax({  
       type: "GET",  
       url: "http://localhost:8000/api/apelido/",  
       data: "",  
       success: function(resp){  
          var text = "coc"+resp.data.apelido;
	      var msg = new SpeechSynthesisUtterance();
	      var voices = window.speechSynthesis.getVoices();
	      msg.voice = voices[16];
	      msg.rate = 1;
	      msg.pitch = 1;
	      msg.text = text;

	      speechSynthesis.speak(msg);
       },  
       error: function(e){  
         alert('Erro requisição');  
       }  
     });
    })
  } else {
    $('#modal1').openModal();
  }
});
</script>