<?php
/*
 * @file: modal_raw.php
 * @info: Crea modal desde 0
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>modal raw</title>
</head>
<body>
<!-- modal -->
<div>
    <button onclick="open_modal()">Open modal</button>
    <div id="modal" class="modal">
        <div id="modal-dialog" class="modal-dialog modal-grid">
            <header class="area-header">
                <h1>Modal title</h1>
                <button onclick="close_modal()">x</button>
            </header>
            <div class="area-body">

            </div>
        </div>
    </div>
</div>


<script>
const $modal = document.getElementById("modal")
const $modalDialog = document.getElementById("modal-dialog")

$modal.addEventListener("click", function (){
  $modal.classList.remove("modal-open")
})

$modalDialog.addEventListener("click", function (e){
  e.stopPropagation()
})

function open_modal()
{
  $modal.classList.remove("modal-close")
  $modal.classList.add("modal-open")
}

function close_modal()
{
  $modal.classList.add("modal-close")
  //$modal.classList.add("modal")
  //$modal.classList.remove("modal-open")
}
</script>
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');
.modal {
  background-color: rgb(0,0,0, .75);
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  display: none;
  /*
  si bien con estos estilos se centra verticalmente usando flex, al hacer mas pequeña (en altura) la ventana
  del navegador se mantiene centrado pero se pierde la parte superior e inferior por eso mejor se usa grid
    */
  justify-content: center;
  align-items: center;
}

.modal-open {
  display: grid;
  animation: anim-show .2s;
}

@keyframes anim-show {
  from {
    transform: scale(0);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

.modal-close {
  opacity: 0; /*esto permite que despues de la animacion se quede oculto*/
  animation: anim-hide .25s;
}

@keyframes anim-hide {
  from {
    transform: scale(1);
    opacity: 1;
  }
  to {
    transform: scale(0);
    opacity: 0;
  }
}

.modal-dialog {
  background: #ddd;
  padding: 10px;
  width: 350px;
  height: 400px;
  border-radius: 1%;
}

.modal-grid {
  display: grid;
  grid-template-areas:
    'area-header'
    'area-body'
}
.modal-header {
  grid-area: area-header;
}
.modal-body {
  grid-area: area-body;
}

</style>
</body>
</html>