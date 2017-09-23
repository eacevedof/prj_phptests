//http://json.theframework.es/data/app_costumer.json
console.log("file:promises.js");
(function(){
    function getUsers(){
        let oPromise = new Promise(function(fnResolve,oReject){
            setTimeout(function(){
                console.log("Users are Ready")
                fnResolve()
            },800)            
        })
        return oPromise
    }
    
    function getCustomers(){
        let oPromise = new Promise(function(fnResolve,oReject){
            setTimeout(function(){
                console.log("Customers are Ready")
                fnResolve()//resolve avisa que esta promesa ha terminado correcamente
            },400)
        })
        return oPromise
    }    
    
    function getProducts(){
        let oPromise = new Promise(function(fnResolve,oReject){
            setTimeout(function(){
                console.log("Products are Ready")
                fnResolve()
            },600)
        })
        return oPromise
    }
    
    getUsers()
        //solo se pasa el callback (el nombre)
        .then(getCustomers)
        .then(getProducts)
})();