<?php
/*
 * @file: crop_first 2.0.0
 * @info: Crop antes de subir una imagen
 */

if($_POST) {
    print_r($_REQUEST);die;
    $folderPath = 'upload/';
    $image_parts = explode(";base64,", $_POST['image']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.png';
    file_put_contents($file, $image_base64);
    echo json_encode(["image uploaded successfully."]);
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
    <form class="" method="post">
        <div class="mb-3">
            <label for="fileImage" class="form-label">Upload Images</label>
            <input type="file" name="image" id="fileImage" class="image">
        </div>
    </form>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>
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
<script>
/*
const $modal = new bootstrap.Modal(
    document.getElementById("modal"), {
        backdrop: true
    })
//$modal.show()
*/
const $file = document.getElementById("fileImage")
const $image = document.getElementById("image")
const $modal = document.getElementById("modal")
const $btncrop = document.getElementById("crop")

let cropper, reader, file;
const bootModal = new bootstrap.Modal($modal, {
    keyboard: false
})

$modal.addEventListener("shown.bs.modal", function (){
    cropper = new Cropper($image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: ".preview"
    })
})
$modal.addEventListener("hidden.bs.modal", function (){
    cropper.destroy()
    cropper = null
})

$btncrop.addEventListener("click", function (){
    const canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    })

    canvas.toBlob(function (blob){
        const url = URL.createObjectURL(blob)
        const reader = new FileReader()
        reader.readAsDataURL(blob)
        reader.onloadend = function (){
            const base64data = reader.result
            const url = "/index.php?f=crop_first"
            fetch(url, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "upload",
                    image: window.btoa(base64data)
                })
            })
            .then(function (response){
                console.log("response",response.json())
                return response.json()
            })
            .then(function (result){
                //alert("uploaded")
                //bootModal.hide()
                console.log("result:",result)
            })

        }
    })

})//btncrop.click


$file.addEventListener("change", function (e) {
    const files = e.target.files

    const on_done = function (url){
        $image.src = url
        bootModal.show()
    }

    if(files && files.length>0){
        const file = files[0]
        if (URL){
            on_done(URL.createObjectURL(file))
        }
        else if (FileReader) {
            const reader = new FileReader()
            reader.onload = function (e) {
                on_done(reader.result)
            }
            reader.readAsDataURL(file)
        }
    }
})




</script>
</body>
</html>