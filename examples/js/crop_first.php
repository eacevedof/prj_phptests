<?php
/*
 * @file: crop_first 2.0.0
 * @info: Crop antes de subir una imagen
 */

$json = file_get_contents("php://input");
$array = json_decode($json, true);
$_POST = $array;
if($_POST){
    $folderPath = 'upload/';
    $image_parts = explode(";base64,", $_POST['image']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.png';
    file_put_contents($file, $image_base64);
    echo json_encode([
        "message"=>"image uploaded successfully.",
        "file"=>$file
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Crop before</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
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
                            <img id="img-original">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
    border: 1px solid red;
}
</style>
<script
        src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"
></script>
<script
        src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"
></script>
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
        width: 160,
        height: 160,
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
                method: 'POST',
                headers: {
                    //si la respuesta del servidor no es un json satará una excepción
                    'Accept': 'application/json',
                    //le indica al servidor que se le enviará un json
                    'Content-Type': 'application/json'
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

let cropper = null
const $modal = document.getElementById("div-modal")
const objmodal = new bootstrap.Modal($modal, {
    keyboard: false
})

$modal.addEventListener("shown.bs.modal", function (){
    cropper = new Cropper($image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: ".preview"
    })
})//modal.on-shown

$modal.addEventListener("hidden.bs.modal", function (){
    cropper.destroy()
    cropper = null
})//modal.on-hidden
</script>
</body>
</html>