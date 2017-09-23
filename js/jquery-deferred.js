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
        //los deferred objects son más pesados que las promesas. Pe. cuenta con done()
        //solo hay compatibilidad de deferred a partir de laversion 3 de jquery
        let oPromise = $.ajax({
            url: sServerUrl.concat(sFile).concat(".json"),
        }).promise()//promise: transforma el deferred object a una promesa
        
        return oPromise;
    }//getDataByAJAX
        
    //endpoints
    let arFiles = ["base_user","app_product_family","app_product_subfamily"]
    
    let arObjDeferred = []
    
    arFiles.forEach((sFile)=>{
        arObjDeferred.push(getDataByAJAX(sFile))
    })
    
    console.log("arObjDeferred",arObjDeferred)
    
    //con apply se puede pasar parametros en un arreglo
    //ejecutaria this.when(arObjDeferred)
    //el metodo apply invoca una función parecido a call, solo que call requiere los parametros separados
    $.when.apply(this,arObjDeferred)
        .then((sUser,sProdFam,sProdSubfam) => {
            console.log("sUser",sUser,"sFam",sProdFam,"sSub",sProdSubfam)
        })
    
//    $.when(getDataByAJAX("base_user")
//        ,getDataByAJAX("app_product_family")
//        ,getDataByAJAX("app_product_subfamily")
//        )
//        .then((sUser,sProdFam,sProdSubfam) => {
//            console.log("sUser",sUser,"sFam",sProdFam,"sSub",sProdSubfam)
//        })
    
    //sin jquery, con ecmascript
    //devuelve un array de arrays en orden de llamada
    //hay q tener cuidado usando .all ya que segun la cantidad de tiempo de recuperacion de los datos
    //estos pueden ralentizar mucho la app. Lo ideal en estos casos seria cargar la visualizacion de modo asincrono 
//    Promise.all([getDataByAJAX("base_user")
//        ,getDataByAJAX("app_product_family")
//        ,getDataByAJAX("app_product_subfamily")]
//        )
//        .then(arResponse=>{
//            arResponse.forEach((arItem,i)=>{
//                console.log(i,arItem)
//            })
//            //console.log(arResponse)
//        })
//    
//    getDataByAJAX("base_user")
//        .then( arUsers =>{
//            console.info("arUsers",arUsers)
//            return getDataByAJAX("app_product_family")
//        })
//        .then( arFamilies =>{
//            console.info("arFamilies",arFamilies)
//            return getDataByAJAX("app_product_subfamily")
//        })
//        .then(arSubfamilies=>{
//            console.info("arSubfamiles",arSubfamilies)
//        })
//        .done(()=>{console.log("done :)")})

})(jQuery);