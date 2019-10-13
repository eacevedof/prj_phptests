## [APAW. 1. Patrones de diseño. 1.9. Observer - Youtube](https://youtu.be/r3TdeykOFZQ?t=5)
- El patrón se basa en que un modelo puede ser observado por varias vistas.
- El modelo tiene un atributo: **estado**
- Cada vez que haya un cambio (con **setState(state:int)**) lanzará el método: **notifyObservers()**
- Ese método avisará a todas las vistas que están observando que se actualicen, es decir que ejecuten su método **update()**
  - Lo más seguro que las vistas creen una nueva instancia del modelo en cuestion, recorran sus atributos y los muestren nuevamente en pantalla.
- Si tienes una flota de coches, cada vez que un coche cambia de posición a visa al mapa que se actualice.

## Mi conclusión:
- El observable notifica usando `observer.update(observable)` donde observable tiene algo para el observador.

- **oObservable** (subject, Postoffice)
  - methods:
    - **arObservers=[]**
    - **subscribe(oObserver)**
    - **unsubscribe(oObserver)**
    - **notify()**
    ```php
    foreach($arObservers as $oObserver) 
      $oObserver.update($this)
      //echo "You have new email:".$this->get_email()
    ```
- **oObserver** (Mailbox)
  - methods:
    - **update(oObservable)**
    ```php
    public function update($oObservable)
    {
      echo "You have new email:".$oObservable->get_email()
    }
    ```    
  