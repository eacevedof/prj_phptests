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
            <input type="file" id="file-upload" class="invisible">
            <button type="button" id="btn-upload" class="btn btn-success invisible">Upload</button>
        </div>
        <div class="col-sm-4">
            <button type="button" id="btn-reset" class="btn btn-primary invisible">Clear</button>
        </div>
    </div>
    <div class="row p-2">
        <p id="p-pasted" class="badge text-dark p-1 font-monospace fs-4 bg-info invisible"></p>
        <img id="img-pasted" src="#" class="img-fluid invisible" />
    </div>
</div>
<script type="module">
const POST_URL = "/index.php?f=paste_from_clipboard&nohome=1"
const $btnreset = document.getElementById("btn-reset")
const $btnupload = document.getElementById("btn-upload")
const $file = document.getElementById("file-upload")
const $image = document.getElementById("img-pasted")
const $p = document.getElementById("p-pasted")

const show = elements => elements.forEach( element => element.classList.remove('invisible') )
const hide = elements => elements.forEach( element => element.classList.add('invisible') )

const load_image = url => {
    hide([$image,$p])
    $image.src = url
    $p.innerText = url
    if(url) {
        show([$image,$p])
    }
}

window.addEventListener("paste", e => {
    const files = e.clipboardData.files
    console.log("window.on-paste", files)
    if (!files) return

    $file.files = files
    const objfile = files[0]
    //el objeto file tiene las propiedades: name, size, type, lastmodified, lastmodifiedate
    console.log("window.on-paste.objfile", objfile)
    const reader = new FileReader()
    reader.onload = function (e) {
        const url = reader.result
        console.log("window.on-paste.reader.onload.url", url)
        load_image(url)
    }
    reader.readAsDataURL(objfile)
});//window.on-paste

$btnreset.addEventListener("click", e => {
    $file.value = ""
    hide([$btnupload, $btnreset, $p, $image])
})

$btnupload.addEventListener("click", e => {
    const objfile = $file.files[0]
    if(!objfile) {
        alert("No image pasted")
        return
    }

    const reader = new FileReader()
    reader.readAsDataURL(objfile)
    reader.onloadend = function () {
        const base64data = reader.result

        fetch(POST_URL, {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                image: base64data
            })
        })
        .then(response => response.json())
        .then(result => {
            console.log("result:", result)
            $file.value = ""
            $image.src = "/" + result.file
            $p.innerText = $image.src
            alert(result.message)
        })
    }
})//btn-upload.on-click

</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
    integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
    crossorigin="anonymous"></script>
</body>
</html>