<?php
/*
 * @file: bootstrap5_toast
 * @info: Ejecuta Bootstrap 5 sin jquery
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Bootstrap 5 toast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
          crossorigin="anonymous"
    >
</head>
<body>
<div class="container">
    <h4>Paste anywhere</h4>
    <div class="row">
        <div class="col-sm-4">
            <input type="text" id="txt-message" class="form-control" placeholder="Toast message" />
        </div>
        <div class="col-sm-4">
            <button type="button" id="btn-toast" class="btn btn-primary">Toast</button>
        </div>
    </div>
</div>

<!-- toast -->
<div class="toast align-items-center text-white bg-primary border-0 mt-3 me-3 position-absolute top-0 end-0"
     style="background-color:#A9C948 !important;"
     role="alert" aria-live="assertive" aria-atomic="true"
>
    <div class="d-flex">
        <div class="toast-body">-</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<script type="module">
const toast = msg => {
    const $toast = document.querySelectorAll(".toast")[0]
    const $toastbody = $toast.getElementsByClassName("toast-body")[0]

    const bootToast = new bootstrap.Toast($toast)
    if($toastbody) {
        $toastbody.innerText = msg
        bootToast.show()
    }
}// toast()

document.getElementById("btn-toast").addEventListener("click", () => {
    const $txtmessage = document.getElementById("txt-message")
    const msg = $txtmessage.value
    toast(msg)
})
</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
    integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
    crossorigin="anonymous"></script>
</body>
</html>