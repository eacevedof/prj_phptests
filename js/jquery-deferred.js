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
        
    $.when(getDataByAJAX("base_user")
        ,getDataByAJAX("app_product_family")
        ,getDataByAJAX("app_product_subfamily")
        )
        .then((sUser,sProdFam,sProdSubfam) => {
            console.log("sUser",sUser,"sFam",sProdFam,"sSub",sProdSubfam)
        })
    
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