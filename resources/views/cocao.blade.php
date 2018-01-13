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
    <div>
      <div class="row">
        <nav>    
          <div class="center-align">
            <a class="brand-logo">iCocão</a>
          <div>
        </nav>
      </div>
      <form class="col s8 offset-s2">
        <div class="row s8">
          <label>Choose voice</label>
          <select id="voices"></select>
        </div>
        <div class="row" >
          <div class="col s4">
            <label>Velocidade</label>
            <p class="range-field">
              <input type="range" id="rate" min="0.1" max="2" value="1" step="0.1" />
            </p>
          </div>
          <div class="col s6" style="padding-top: 25px;">
            <div class="switch">
              <label>
                Vozinha Off
                <input type="checkbox" id="vozinha">
                <span class="lever"></span>
                Vozinha On
              </label>
            </div>
          </div>
        </div>
        <div class="row" style="display: flex;
    align-items: center;
    justify-content: center;">
          <div class="input-field col s4">
            <input type="text" id="message" class="validate" disabled></input>
          </div>
        </div>

        <div>
          <div class="row" style="display: flex;
    align-items: center;
    justify-content: center;">
            <div id="buscaAudio">
              <a href="#" id="speak" class="waves-effect waves-light btn">Busca Texto</a>
            </div>
            <div id="tocarDenovo" style="display: none">
              <a href="#" id="tocarAudio" class="waves-effect waves-light btn">Escutar novamente</a>
            </div>
          </div>

          <div>
            <div id="caixaAvalia" style="display: none" >
              <div class="row">
                <div class="col s2">
                  <a href="#" id="a1" class="waves-effect waves-blue btn col s12" style="background: red">1</a>
                </div>
                <div class="col s2">
                  <a href="#" id="a2" class="waves-effect waves-blue btn col s12" style="background: red">2</a>
                </div>
                <div class="col s2">
                  <a href="#" id="a3" class="waves-effect waves-blue btn col s12" style="background: red">3</a>
                </div>
                <div class="col s2">
                  <a href="#" id="a4" class="waves-effect waves-blue btn col s12" style="background: red">4</a>
                </div>
                <div class="col s2">
                  <a href="#" id="a5" class="waves-effect waves-blue btn col s12" style="background: red">5</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>  
    </div>

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

          if(voice.name.toLowerCase().split("brasil").length > 1 || voice.name.toLowerCase().split("brazil").length > 1) {
            voice_id = index;
          }

          console.log(voice.name)
          $voicelist.append($option);
        });

        if(voice_id === -1)
         $('#modal1').openModal();
        else
          $('#voices').find('option[value='+voice_id+']').prop('selected', true);
        $("#voices").material_select();
      }
    }

    var atual = ''
    var ids = []

    var tocaAudio = () => {
      $("#message").val("coc"+atual)
      var text = $('#message').val();
      var msg = new SpeechSynthesisUtterance();
      var voices = window.speechSynthesis.getVoices();
      console.log($('#voices').val(), $('#rate').val()/10, $('#pitch').val())
      msg.voice = voices[$('#voices').val()];
      msg.rate = $('#rate').val();
      msg.pitch = ($('#vozinha').prop('checked')) ? 2 : 1;
      msg.text = text;

      speechSynthesis.speak(msg);
    }

    $('#tocarAudio').click(function(){
      tocaAudio()
    })

    $('#speak').click(function(){
      $.ajax({
       type: "GET",  
       url: "http://icocao.ddns.net/api/apelido/",  
       data: "",  
       success: function(resp){  
        atual = resp.data.apelido
        ids = resp.data.ids
        $('#tocarDenovo').css("display", "inline")
        $('#caixaAvalia').css("display", "inline")
        $('#buscaAudio').css("display", "none")
        tocaAudio()
       },  
       error: function(e){  
         alert('Erro requisição');  
       }  
     });
    })

    var tocaAvalia = function(valor) {
      $.ajax({
        type: "POST",  
        url: "http://icocao.ddns.net/api/avalia/",  
        data: {apelido: atual, ids: ids, valor: valor*1.5},
        success: function(resp){
          atual = resp.data.apelido
          ids = resp.data.ids
          tocaAudio()
        }
      })
    }

    $('#a1').click(function() {tocaAvalia(-10)})
    $('#a2').click(function() {tocaAvalia(-5)})
    $('#a3').click(function() {tocaAvalia(2)})
    $('#a4').click(function() {tocaAvalia(5)})
    $('#a5').click(function() {tocaAvalia(10)})
  } else {
    $('#modal1').openModal();
  }
});
</script>