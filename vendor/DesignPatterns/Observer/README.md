## Resumen:
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
  