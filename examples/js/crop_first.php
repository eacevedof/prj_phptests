<?php
/*
 * @file: crop_first 2.0.0
 * @info: Crop antes de subir una imagen
 */

//cuando se envía como json el dato no llega en $_POST sino php://input
if($json = file_get_contents("php://input"))
{
    $post = json_decode($json, true);

    //image => data:image/png;base64,iVBORw0KGgoAAAA....
    $parts = explode(";base64,", $post["image"]);
    //$image_type_aux = explode("image/", $parts[0]);
    //$image_type = $image_type_aux[1];

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
    <title>Cropper.js</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <link href="/js/cropper-js/cropper.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    <form class="form">
        <div class="mb-3">
            <label for="file-img" class="form-label">Upload Images</label><br/>
            <input type="file" name="image" id="file-img" class="image">
        </div>
    </form>
    <img src="#" id="img-uploaded" style="visibility: hidden;" class="img-fluid" />
    <span id="span-uploaded"></span>
</div>
<div class="modal fade" id="div-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="img-original" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <div id="div-preview" class="preview img-fluid"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-crop">Crop</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
img {
    display: block;
    max-width: 100%;
}
.preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid #0B5ED7;
}
</style>
<script src="/js/cropper-js/cropper.js"></script>
<script type="module">
const $file = document.getElementById("file-img")
const $image = document.getElementById("img-original")

$file.addEventListener("change", function (e) {
    const load_image = function (url){
        $image.src = url
        objmodal.show()
    }

    const files = e.target.files

    if(files && files.length>0) {
        const file = files[0]
        //el objeto file trae name, size, type, lastmodified, lastmodifiedate
        console.log("file.on-change",file)
        if (URL){
            console.log("on-change URL")
            //crea una url del estilo: blob:http://localhost:1024/129e832d-2545-471f-8e70-20355d8e33eb
            const url = URL.createObjectURL(file)
            console.log("createobjecturl",url)
            load_image(url)
        }
        else if (FileReader) {
            console.log("on-change FileReader")
            const reader = new FileReader()
            reader.onload = function (e) {
                load_image(reader.result)
            }
            reader.readAsDataURL(file)
        }
    }
})//file.on-change

const $btncrop = document.getElementById("btn-crop")
$btncrop.addEventListener("click", function (){
    const canvas = cropper.getCroppedCanvas({
        width: 250,
        height: 250,
    })

    canvas.toBlob(function (blob){
        //el objeto blob tiene: size y type
        console.log("blob",blob)
        //const url = URL.createObjectURL(blob)
        //console.log("url",url)
        const reader = new FileReader()
        reader.readAsDataURL(blob)

        reader.onloadend = function (){
            const base64data = reader.result
            //base64data es un string del tipo: data:image/png;base64,iVBORw0KGgoAAAA....
            console.log("base64data", base64data)
            const url = "/index.php?f=crop_first&nohome=1"
            //const data = new FormData()
            //data.append("image", base64data)

            fetch(url, {
                method: "POST",
                headers: {
                    //si la respuesta del servidor no es un json satará una excepción
                    "Accept": "application/json",
                    //le indica al servidor que se le enviará un json
                    "Content-Type": "application/json"
                },

                //body: data
                body: JSON.stringify({
                    image: base64data
                })
            })
            .then(response => response.json())
            .then(function (result){
                $file.value = "" //resetea el elemento file
                objmodal.hide()
                //result es algo como: ["image uploaded successfully."]
                console.log("result:",result)
                alert(result.message)
                const $img = document.getElementById("img-uploaded")
                $img.src = "/"+result.file
                $img.style.visibility = "visible"
                const $span = document.getElementById("span-uploaded")
                $span.innerText=$img.src
            })
        }//reader.on-loaded
    })//canvas.toblob
})//btncrop.on-click

const $modal = document.getElementById("div-modal")
const objmodal = new bootstrap.Modal($modal, {
    keyboard: false
})

let cropper = null
$modal.addEventListener("shown.bs.modal", function (){
    console.log("modal.on-show")
    //crea el marco de selección sobre el objeto $image
    cropper = new Cropper($image, {
        //donde se mostrará lo parte seleccionada
        preview: document.getElementById("div-preview"),
        //3: indica que no se podrá seleccionar fuera de los límites
        viewMode: 3,
        //NaN libre elección, 1 cuadrado, proporción del lado horizontal con respecto al vertical
        aspectRatio: 1.5,
    })
})//modal.on-shown

$modal.addEventListener("hidden.bs.modal", function (){
    console.log("modal.on-hide")
    cropper.destroy()
    cropper = null
})//modal.on-hidden
</script>
</body>
</html>