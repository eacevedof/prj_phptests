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
        <div class="col-sm-4 visually-hidden">
            <label for="file-upload" class="form-label">Upload Images</label><br/>
            <input type="file" id="file-upload" class="image">
        </div>
        <div class="col-sm-4">
            <button type="button" class="btn btn-secondary" id="btn-upload">Upload</button>
        </div>
        <div class="col-sm-4">
            <button type="button" class="btn btn-primary" id="btn-reset">Clear</button>
        </div>
    </div>
    <div class="row p-2">
        <p id="span-pasted" class="badge bg-info text-dark p-1 font-monospace fs-4"></p>
        <img src="#" id="img-pasted" style="visibility: hidden;" class="img-fluid" />
    </div>
</div>
<script type="module">
const $form = document.getElementById("form-upload")
const $btnreset = document.getElementById("btn-reset")
const $btnupload = document.getElementById("btn-upload")
const $file = document.getElementById("file-upload")
const $image = document.getElementById("img-pasted")
const $span = document.getElementById("span-pasted")

$btnreset.addEventListener("click", e => {
    $file.value = ""
    $image.style.visibility="hidden"
    $span.style.visibility="hidden"
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
        const url = "/index.php?f=paste_from_clipboard&nohome=1"
        const base64data = reader.result

        fetch(url, {
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
        .then(function (result) {
            $file.value = ""
            console.log("result:", result)
            alert(result.message)
            const $img = document.getElementById("img-pasted")
            $img.src = "/" + result.file
            const $span = document.getElementById("span-pasted")
            $span.innerText = $img.src
        })
    }
})//btn-upload.on-click


$file.addEventListener("change", function (e) {
    console.log("file.on-change")
    const files = e.target.files

    if(files && files.length>0) {
        const objfile = files[0]
        //el objeto file tiene las propiedades: name, size, type, lastmodified, lastmodifiedate
        console.log("file.on-change", objfile)
        if (URL){
            console.log("file.on-change URL")
            //crea una url del estilo: blob:http://localhost:1024/129e832d-2545-471f-8e70-20355d8e33eb
            const url = URL.createObjectURL(objfile)
            $image.src = url
            $span.innerText = url
            console.log("createobjecturl", url)
        }
        else if (FileReader) {
            console.log("file.on-change FileReader")
            const reader = new FileReader()
            reader.onload = function (e) {
                const url = reader.result
                $image.src = url
                $span.innerText = url
            }
            reader.readAsDataURL(objfile)
        }
    }
})//file.on-change

window.addEventListener("paste", e => {
    const files = e.clipboardData.files
    console.log("window.on-paste", files)
    $file.files = files

    const load_image = function (url){
        $image.style.visibility="hidden"
        $span.style.visibility="hidden"

        $image.src = url
        $span.innerText = url
        if(url) {
            $image.style.visibility="visible"
            $span.style.visibility="visible"
        }
    }

    if(files && files.length>0) {
        const objfile = files[0]
        //el objeto file tiene las propiedades: name, size, type, lastmodified, lastmodifiedate
        console.log("window.on-paste", objfile)
        if (URL){
            console.log("on-change URL")
            //crea una url del estilo: blob:http://localhost:1024/129e832d-2545-471f-8e70-20355d8e33eb
            const url = URL.createObjectURL(objfile)
            console.log("createobjecturl", url)
            load_image(url)
        }
        else if (FileReader) {
            console.log("window.on-paste FileReader")
            const reader = new FileReader()
            reader.onload = function (e) {
                load_image(reader.result)
            }
            reader.readAsDataURL(objfile)
        }
    }
});//window.on-paste
</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
    integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
    crossorigin="anonymous"></script>
</body>
</html>