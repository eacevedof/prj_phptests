//http://json.theframework.es/data/app_costumer.json
//Promesas A+:  Es una promesa que cumple con un standard
//las promesas según el standard a+ deben tener un metodo then
//Reason: El argumento (mensaje) que recibe fnReject(reas)
console.log("file:promises.js");
(function(){
    getUsers = ()=>{
        let oPromise = new Promise(function(fnResolve,fnReject){
            setTimeout(function(){
                console.log("Users are Ready")
                //se pasa como parámetro un array, este array se pasara
                //como parámetro de la funcion anonima que esta en then: then(fn(array){...})
                //fnResolve(["u7","u8","u9"])
                fnReject("Base de datos inaccesible al recuperar usuarios");
            },800)            
        })
        return oPromise
    }
    
     getCustomers=()=>{
        let oPromise = new Promise(function(fnResolve,fnReject){
            setTimeout(function(){
                console.log("Customers are Ready")
                fnResolve(["c3","c4","c20"])//resolve avisa que esta promesa ha terminado correcamente
                //fnReject("error al obtener customers")
            },400)
        })
        return oPromise
    }    
    
    getProducts = ()=>{
        let oPromise = new Promise(function(fnResolve,fnReject){
            setTimeout(function(){
                console.log("Products are Ready")
                fnResolve([true,false,null,undefined])
            },600)
        })
        return oPromise
    }
    
    getUsers()
        //solo se pasa el callback (el nombre)
        .then((arUsers)=>{
            console.log(arUsers)
            throw "Error en arUsers"
            return getCustomers()
        })
        .then((arCustomers)=>{
            console.log(arCustomers)
            return getProducts()
        })
        .catch((oErr)=>{
            console.log("Error",oErr)
        })
})();