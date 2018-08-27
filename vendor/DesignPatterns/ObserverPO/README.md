# [Observer Pattern](https://youtu.be/rWvXJo3OAzs)
## Post Office System

- Que pasaria si tuvieras que ir todos los días a la oficina de correos para comprobar si tienes correspondencia
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b83d1d85831ec8cb01083e3/534c35d079f1f575d00d20413c354f88/image.png" height="200" width="400">
- la solución pasa por definir un patrón Observador
- Se define un **Subject = POST OFFICE** (el objeto a observar)
- Se define un/unos observadores **Observers = Homes** 
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b83d1d85831ec8cb01083e3/2c9ee13785067b1cf1f66b60111dae93/image.png" height="200" width="400">
- El patrón observador depende de los suscriptores **oPostoffice.subscribe(oMailBox)**. Solo si estas suscrito eres un observador.
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b83d1d85831ec8cb01083e3/ba62f50b5c020149292d7ba1e22657ea/image.png" height="200" width="400">
- Por lo tanto un observador puede cancelar la suscripción **oPostoffice.unsubscribe(oMailBox)**
- Diagrama UML 
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b83d1d85831ec8cb01083e3/98445e15f8e4cd4baa3a2d886b5be4c2/image.png" height="200" width="400">
- Piezas:
    - **If**Subject (el observado)
        - add_observer()
        - remove_observer()
        - notify_observers()

    - **If**Observer (el observador)
        - update()
    
    - **Cls**PostOffice : IfSubject
        - **add_observer()**
        - **remove_observer()**
        - **notify_observers()** llama a todos los `oMailBox.update()`
        - get_address()
        - post_office()
        - new_mail()

    - **Cls**MailBox : IfObserver
        - **update()**
        - mail_box()

## Notas

- He visto que si despliego tal cual está el ejemplo en java 
- se notificaria siempre a todos los observadores independientemente de que la direccion
- de la correspondencia sea de alguno de ellos.


