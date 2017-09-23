//http://json.theframework.es/data/app_costumer.json
//Promesas A+:  Es una promesa que cumple con un standard
//las promesas según el standard a+ deben tener un metodo then
//Reason: El argumento (mensaje) que recibe fnReject(reas)
//Polyfill: es6 promise. Da soporte de promesas a navegadores antiguos
//Polyfill.io  Pequeño que script que cargara solo lo que necesite el navegador del usuario final discriminando el resto de navegadores
//tiene promises
//diferencia entre promise y observable es que la promesa se ejecuta una vez el observable se queda a la escucha
//consejo: no concatenar mas de 10 promesas
console.log("file:promises.js");
(()=>{
    getUsers = ()=>{
        let oPromise = new Promise((fnResolve,fnReject)=>{
            setTimeout(()=>{
                console.log("Users are Ready")
                //se pasa como parámetro un array, este array se pasara
                //como parámetro de la funcion anonima que esta en then: then(fn(array){...})
                fnResolve({code:100,data:["u7","u8","u9"]})
                //fnReject({code:-1,data:"Base de datos inaccesible al recuperar usuarios"});
            },800)            
        })
        return oPromise
    }
    
     getCustomers = ()=>{
        let oPromise = new Promise((fnResolve,fnReject)=>{
            setTimeout(()=>{
                console.log("Customers are Ready")
                fnResolve(["c3","c4","c20"])//resolve avisa que esta promesa ha terminado correcamente
                //fnReject({code:-1,data:"Base de datos inaccesible al recuperar usuarios"});
            },400)
        })
        return oPromise
    }    
    
    getProducts = ()=>{
        let oPromise = new Promise((fnResolve,fnReject)=>{
            setTimeout(()=>{
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
        .catch((sReason)=>{
            console.log("Error",sReason)
        })
})();