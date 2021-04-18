<?php
/*
 * @file: paste_from_clipboard
 * @info: Pega una imagen en input file
 */

//cuando se envía como json el dato no llega en $_POST sino php://input
if($json = file_get_contents("php://input"))
{
    $post = json_decode($json, true);

    //image => data:image/png;base64,iVBORw0KGgoAAAA....
    $parts = explode(";base64,", $post["image"]);

    //$strbase64: �PNG  IHDR��󠒱 IDATx^���gv�U�˹_�42�@�Yaf�I�,{m�Ɩ���8h����H�h5Z�v5��+k�Y�$+L�H+�f
    $strbase64 = base64_decode($parts[1]);

    $uuid = uniqid();
    if($name = trim($post["name"])) $uuid = $name;
    $pathfile = "upload/$uuid.png";
    file_put_contents($pathfile, $strbase64);

    echo json_encode([
        "message" => "image uploaded successfully.",
        "file"    => $pathfile
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Paste from Clipboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h4>Paste anywhere</h4>
    <div class="row">
        <div class="col-sm-4">
            <input type="text" id="txt-name" class="form-control invisible" placeholder="Image name" />
        </div>
        <div class="col-sm-4">
            <button type="button" id="btn-upload" class="btn btn-success invisible">Upload</button>
        </div>
        <div class="col-sm-4">
            <button type="button" id="btn-reset" class="btn btn-primary invisible">Clear</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <input type="file" id="file-upload" class="invisible" />
            <p id="p-pasted" class="badge overflow-wrap p-1 font-monospace text-dark bg-info invisible" style="width: 75%"></p>
            <img id="img-pasted" src="#" class="img-fluid border border-info border-3 invisible" />
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

<!-- esto se puede pasar a un archivo -->
<script type="module">
const POST_URL = "/index.php?f=paste_from_clipboard&nohome=1"

const $txtname = document.getElementById("txt-name")
const $btnreset = document.getElementById("btn-reset")
const $btnupload = document.getElementById("btn-upload")
const $file = document.getElementById("file-upload")
const $image = document.getElementById("img-pasted")
const $p = document.getElementById("p-pasted")

const $toast = document.querySelectorAll(".toast")[0]
const bootToast = new bootstrap.Toast($toast)

const show = elements => elements.forEach( element => element.classList.remove('invisible') )
const hide = elements => elements.forEach( element => element.classList.add('invisible') )

const load_image = url => {
    hide([$image])
    $image.src = url
    if(url) {
        show([$image,$p])
    }
}// load_image()

const toast = msg => {
    const $toastbody = $toast.getElementsByClassName("toast-body")[0]
    if($toastbody) {
        $toastbody.innerText = msg
        bootToast.show()
    }
}// toast()

const post = data => fetch(POST_URL, {
    method: "POST",
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
            image: data,
            name: $txtname.value
        })
    })
    .then(response => response.json())
    .then(result => {
        console.log("result:", result)
        $file.value = ""
        $image.src = "/" + result.file
        $p.innerText = $image.src
        hide([$txtname, $btnreset, $btnupload])
        toast(result.message)
    })//post()

window.addEventListener("paste", e => {
    const files = e.clipboardData.files
    console.log("window.on-paste", files)
    if (!files) return

    $file.files = files
    const url = URL.createObjectURL(files[0])
    $p.innerText = url
    show([$p, $btnupload, $btnreset, $txtname])
    load_image(url)
    $txtname.focus()
});//window.on-paste

$btnreset.addEventListener("click", () => {
    $file.value = ""
    $txtname.value = ""
    hide([$btnupload, $btnreset, $p, $image, $txtname])
})//btn-reset.on-click

$btnupload.addEventListener("click", () => {
    const objfile = $file.files[0]
    if(!objfile) {
        return toast("No image pasted")
    }

    const reader = new FileReader()
    reader.readAsDataURL(objfile)
    reader.onloadend = () => post(reader.result)
})//btn-upload.on-click

</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
    integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
    crossorigin="anonymous"></script>
</body>
</html>