//webtraining.zone
////file: jquery-deferred.js (diferido)
//definimos un scope

//app_product_family.csv
(($)=>{
    //Deferred Objects
    let sServerUrl = "http://json.theframework.es/index.php?getfile="
    
    let getDataByAJAX = (sFile)=>{
        //$.ajax devuelve un objeto deferred que es compatible con un objeto 
        //Promise A+
        //con lo cual cuenta con un metodo .then
        //y etados pending, rejected y fullfill
        //y tiene otro metodo promise() que hace la transformacion
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
        }).promise()//promise: transforma el deferred object a una promesa
        
        //devuelve un objeto deferido
        return oJqAjax;
    }//getDataByAJAX
    
    let oJqAjax = getDataByAJAX("base_user.json")
    //console.log("oJqAjax",oJqAjax)

})(jQuery);