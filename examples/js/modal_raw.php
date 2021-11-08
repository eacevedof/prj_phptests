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
        <div class="modal-dialog">
            <h1>Modal title</h1>
            <button onclick="close_modal()">x</button>
        </div>
    </div>
</div>


<script>
const $modal = document.getElementById("modal")
function open_modal()
{
  //$modal.classList.remove("modal")
  $modal.classList.add("modal-open")
}

function close_modal()
{
  $modal.classList.remove("modal-open")
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
  justify-content: center;
  align-items: center;
}

.modal-open {
  display: flex;
}
.modal-dialog {
  background: #ddd;
  padding: 10px;
  width: 300px;
  height: 400px;
}


</style>
</body>
</html>