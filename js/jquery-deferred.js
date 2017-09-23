//webtraining.zone
////file: jquery-deferred.js (diferido)
//definimos un scope

//app_product_family.csv
(($)=>{
    //Deferred Objects
    let sServerUrl = "http://json.theframework.es/index.php?getfile="
    
    let getDataByAJAX = (sFile)=>{
        let oJqAjax = $.ajax({
            url: sServerUrl.concat(sFile),
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
        }).promise()
        
        //devuelve un objeto deferido
        return oJqAjax;
    }//getDataByAJAX
    
    let oJqAjax = getDataByAJAX("base_user.json")
    //console.log("oJqAjax",oJqAjax)

})(jQuery);