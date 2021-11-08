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
        :)
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
  background-color: tomato;
  display: none;
}

.modal-open {
  display: flex;
}

</style>
</body>
</html>