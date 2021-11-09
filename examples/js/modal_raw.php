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
        <div id="modal-dialog" class="modal-dialog modal-dialog-grid">
            <header class="area-header debug">
                <h2>Modal title</h2>
                <button onclick="close_modal()">x</button>
            </header>
            <div class="area-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vulputate iaculis sagittis. Aliquam erat volutpat. Nunc mattis velit fringilla consectetur porta. Fusce pulvinar nisi vitae nisl vestibulum ornare. Fusce libero dolor, elementum vel dictum ac, rutrum et ipsum. In egestas vitae dolor et elementum. Vivamus mollis nulla at justo hendrerit, at mattis urna laoreet. In volutpat dui in scelerisque feugiat. Sed nisi odio, vestibulum quis purus sed, pretium molestie nisi. Praesent euismod massa mauris, sit amet vehicula erat lacinia sit amet. Donec eget ultrices felis. Maecenas eget augue tortor.
                </p>
                <p>
                    Aenean laoreet tempor mauris non vulputate. Sed ut erat erat. Vestibulum dignissim enim sem, vel pharetra enim dignissim ut. Praesent ornare, ex vel aliquam facilisis, velit diam sagittis nulla, sed gravida velit erat sit amet dolor. Maecenas accumsan mauris felis. Praesent et dolor arcu. Aenean et ex vel mauris egestas imperdiet. Integer suscipit libero eget erat congue facilisis. Nam feugiat condimentum sem, at aliquam elit placerat at. Donec auctor nulla eget neque tempor pellentesque. Donec hendrerit rutrum ultricies. Curabitur laoreet leo eros, vitae rhoncus nisi hendrerit at. Sed blandit arcu eu tortor scelerisque aliquet.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
const $modal = document.getElementById("modal")
const $modalDialog = document.getElementById("modal-dialog")

$modal.addEventListener("click", function (){
  $modal.classList.remove("modal-show")
})

$modalDialog.addEventListener("click", function (e){
  e.stopPropagation()
})

function open_modal()
{
  $modal.classList.remove("modal-hide")
  $modal.classList.add("modal-show")
}

function close_modal()
{
  $modal.classList.add("modal-hide")
}
</script>
<style>
@import url("https://fonts.googleapis.com/css?family=Roboto&display=swap");
: root {
  --bg-modal: rgb(0,0,0, .75);
  --bg-dialog: #fff;
}

body {
  /*para tener una referencia sobre rem*/
  font-size: 16px;
}

.debug: {
  border:1px dashed red;
}

.modal {

  font-family: "Roboto", "sans-serif";
  background-color: rgb(0,0,0, .75);
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 10;
  display: none;
  /*
  si bien con estos estilos se centra verticalmente usando flex, al hacer mas pequeña (en altura) la ventana
  del navegador se mantiene centrado pero se pierde la parte superior e inferior por eso mejor se usa grid
    */
  justify-content: center;
  align-items: center;
}

.modal-show {
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

.modal-hide {
  z-index: -1;
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
  background: #fff;
  padding: 10px;
  width: 37.5em;
  min-height: 25em;
  border-radius: 1%;
}

.modal-dialog-grid {
  display: grid;
  grid-template-areas:
    "area-header"
    "area-body"
}
.area-header {
  grid-area: area-header;
  display: flex;
  justify-content: space-between;
}

.area-header button {
  background: #0d6efd;
  color: white;
  width: 2em;
  height: 2em;
  border-radius: 1%;
  border: 1px solid #86b7fe;
  align-items: center;
}

.area-body {
  border: 1px solid red;
  grid-area: area-body;
  margin: 0;
  padding: 0;
}

@media (max-height: 500px) {
  .modal-dialog {
    position: fixed;
    top: 0.13rem;
  }
}

/*
breakpoints de referencia que usa bootstrap
*/
@media (max-width:575.98px){
  body {
    font-size: 14px;
  }
  .modal-dialog {
    width: 30.63em;
  }
}

@media (max-width:767.98px){

}

@media (max-width:991.98px){

}

@media (max-width:1399.98px){

}
</style>
</body>
</html>