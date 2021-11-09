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
<style>
  @import url("https://fonts.googleapis.com/css?family=Roboto");
  .debug {
    /*
    usando la consola para agregar un borde a los elementos y ver sus limites
    */
    border:1px dashed red;
  }

  body {
    font-family: "Roboto", "sans-serif";
    /*
    para tener una referencia y poder trabajar con em y rem (ver el breakpoint)
    */
    font-size: 16px;
  }

  /*
  es el div de fondo negro
  */
  .modal-wrapper {
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
    z-index: -1; /*hace que no se quede una capa sobre el boton de apertura que no permite hacer click*/
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

  /*
  modal-dialog es la caja blanca donde va el contenido. El modal en sí.
  */
  .modal-dialog {
    background: #fff;
    padding: 10px;
    width: 37.5em;
    min-height: 25em;
    border-radius: 1%;
  }

  .modal-dialog-grid {
    display: grid;
    grid-template-rows: 3.44em calc(90vh - 3.44em);
    grid-template-areas:
    "area-header"
    "area-body"
  }
  .area-header {
    grid-area: area-header;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .area-header button {
    background: #0d6efd;
    color: white;
    width: 2em;
    height: 2em;
    border-radius: 1%;
    border: 1px solid #86b7fe;
  }

  .area-header h2 {
    margin: 0;
    padding: 0;
    padding-top: 0.15em;
    position: sticky;
    top:0;
  }

  .area-body {
    grid-area: area-body;
    margin: 0;
    padding: 0;
  }

  /*
  breakpoints de referencia que usa bootstrap
  dejo de ejemplo solo este pero habria que tratarlo para los otros bp
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
    /*to-do*/
  }

  @media (max-width:991.98px){
    /*to-do*/
  }

  @media (max-width:1399.98px){
    /*to-do*/
  }
</style>
</head>
<body>
<main>
    <button type="button" id="btn-open">Open modal</button>
    <button type="button" id="btn-open-2">Open modal object</button>

    <div id="modal" class="modal-wrapper">
        <div class="modal-dialog modal-dialog-grid" role="modal-dialog">
            <header class="area-header">
                <h2 role="title">Modal title</h2>
                <button type="button" role="btn-close">x</button>
            </header>
            <div class="area-body" role="body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vulputate iaculis sagittis. Aliquam erat volutpat. Nunc mattis velit fringilla consectetur porta. Fusce pulvinar nisi vitae nisl vestibulum ornare. Fusce libero dolor, elementum vel dictum ac, rutrum et ipsum. In egestas vitae dolor et elementum. Vivamus mollis nulla at justo hendrerit, at mattis urna laoreet. In volutpat dui in scelerisque feugiat. Sed nisi odio, vestibulum quis purus sed, pretium molestie nisi. Praesent euismod massa mauris, sit amet vehicula erat lacinia sit amet. Donec eget ultrices felis. Maecenas eget augue tortor.
                </p>
                <p>
                    Aenean laoreet tempor mauris non vulputate. Sed ut erat erat. Vestibulum dignissim enim sem, vel pharetra enim dignissim ut. Praesent ornare, ex vel aliquam facilisis, velit diam sagittis nulla, sed gravida velit erat sit amet dolor. Maecenas accumsan mauris felis. Praesent et dolor arcu. Aenean et ex vel mauris egestas imperdiet. Integer suscipit libero eget erat congue facilisis. Nam feugiat condimentum sem, at aliquam elit placerat at. Donec auctor nulla eget neque tempor pellentesque. Donec hendrerit rutrum ultricies. Curabitur laoreet leo eros, vitae rhoncus nisi hendrerit at. Sed blandit arcu eu tortor scelerisque aliquet.
                </p>
            </div>
        </div>
    </div>

    <div id="modal-2" class="modal-wrapper">
        <div class="modal-dialog modal-dialog-grid" role="modal-dialog">
            <header class="area-header">
                <h2 role="title"></h2>
                <button type="button" role="btn-close">x</button>
            </header>
            <div class="area-body" role="body">
                example body
            </div>
        </div>
    </div>
</main>
<script type="module">
const $btnOpen = document.getElementById("btn-open")
const $modalWrapper = document.getElementById("modal")
const $modalDialog = $modalWrapper.querySelector(":scope > [role='modal-dialog']")
const $btnClose = $modalDialog.querySelector(":scope > header > [role='btn-close']")

$btnOpen.addEventListener("click", () => {
  $modalWrapper.classList.remove("modal-hide")
  $modalWrapper.classList.add("modal-show")
})

$modalWrapper.addEventListener("click", () => $modalWrapper.classList.add("modal-hide"))
//si hacemos click en la zona blanca evitamos que llegue el evento al modalWrapper y se cierre el modal
$modalDialog.addEventListener("click", e => e.stopPropagation())
$btnClose.addEventListener("click", () => $modalWrapper.classList.add("modal-hide"))
</script>

<script type="module">
//funcion tipo clase
function MyModal(idModal, idOpener=null) {

  const $modal = document.getElementById(idModal)
  if(!$modal) return console.log("no modal found!")

  const $dialog = $modal.querySelector(":scope > [role='modal-dialog']")
  const $title = $dialog.querySelector(":scope > header > [role='title']")
  const $btnClose = $dialog.querySelector(":scope > header > [role='btn-close']")
  const $body = $dialog.querySelector(":scope > [role='body']")
  const $opener = idOpener ? document.getElementById(idOpener) : null

  const show = () => {
    $modal.classList.remove("modal-hide")
    $modal.classList.add("modal-show")
  }

  const hide = () => $modal.classList.add("modal-hide")

  const add_listeners = () => {
    $modal.addEventListener("click", hide)
    if ($dialog) $dialog.addEventListener("click", e => e.stopPropagation())
    if ($opener) $opener.addEventListener("click", show)
    if ($btnClose) $btnClose.addEventListener("click", hide)
    return this
  }

  this.show = function (fnBefore, fnAfter) {
    let r = true
    if(fnBefore) r = fnBefore()
    if(!r) return this;
    show()
    if(fnAfter) fnAfter()
    return this
  }

  this.hide = function (fnBefore, fnAfter) {
    let r = true
    if(fnBefore) r = fnBefore()
    if(!r) return this;
    hide()
    if(fnAfter) fnAfter()
    return this
  }

  this.set_body = function (html) {
    if(!html || !$body) return this
    $body.innerHTML = html
    return this
  }

  this.set_title = function (html) {
    if(!html || !$title) return this
    $title.innerHTML = html
    return this
  }

  this.destroy = () => {
    if($modal) $modal.removeEventListener("click", hide)
    if($opener) $opener.removeEventListener("click", show)
    if($btnClose) $btnClose.removeEventListener("click", hide)
    if($title) $title.innerHTML = ""
    if($body) $body.innerHTML = ""
    return null
  }

  return add_listeners()

}//MyModal

const mymodal = new MyModal("modal-2", "btn-open-2")
mymodal
  .set_title("<span>Some Title</span>")
  .set_body("<p>Un ejemplo en el cuerpo</p>")
  .show()
  //.destroy()
</script>
</body>
</html>