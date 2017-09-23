//webtraining.zone
////file: jquery-deferred.js (diferido)
//definimos un scope
(($)=>{
    //Deferred Objects
    let sServerUrl = "http://json.theframework.es/index.php?getfile=";
    $.ajax({
        url: sServerUrl.concat("base_user.json"),
        headers:{
            //estas cabeceras se usan para APIS que acepta CORS
            //"Content-Type":"application/json",
            //"Api-Token":"1234"
        },
        success:(sResponse)=>{
            console.info("users",sResponse)
        },
        error:(sResponse)=>{
            console.log("error",sResponse)
        }
    })
})(jQuery);