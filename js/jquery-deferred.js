//webtraining.zone
////file: jquery-deferred.js (diferido)
//definimos un scope
(($)=>{
    //Deferred Objects
    let sServerUrl = "http://json.theframework.es/index.php?getfile=";
    $.ajax({
        url: sServerUrl.concat("base_user.json"),
        headers:{
            //"Content-Type":"application/json",
            //"Api-Token":"1234"
        },
        success:(oResponse)=>{
            console.log("success",oResponse)
        },
        error:(oResponse)=>{
            console.log("error",oResponse)
        }
    })
})(jQuery);