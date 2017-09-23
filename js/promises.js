//http://json.theframework.es/data/app_costumer.json
console.log("file:promises.js");
(function(){
    function getUsers(){
        setTimeout(function(){
            console.log("Users are Ready")
        },800)
    }
    
    function getCustomers(){
        setTimeout(function(){
            console.log("Customers are Ready")
        },400)
    }    
    
    function getProducts(){
        setTimeout(function(){
            console.log("Products are Ready")
        },800)
    }
    
    getUsers()
    getCustomers()
    getProducts()
})();