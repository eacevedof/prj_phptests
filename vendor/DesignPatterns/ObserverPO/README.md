# [Youtube - Observer Pattern by Mohammad Alqerm](https://youtu.be/rWvXJo3OAzs)
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
        - update(IfSubject)
    
    - **Cls**PostOffice : IfSubject
        - **add_observer()**
        - **remove_observer()**
        - **notify_observers()** llama a todos los `oMailBox.update(this)`
        - get_address()
        - post_office()
        - new_mail()

    - **Cls**MailBox : IfObserver
        - **update(IfSubject)**
        - mail_box()

## Notas

- He visto que si despliego tal cual está el ejemplo en java 
- se notificaria siempre a todos los observadores independientemente de que la direccion
- de la correspondencia sea de alguno de ellos.

```php
<?php
class ClsMailBox implements IfObserver

    public function update(IfSubject $oIfSubj) 
    {
        if($oIfSubj->get_address() == $this->sAddress)
            \dg::p("You have new mail in $this->sAddress");
        //else
            //\dg::p("NO MAIL for: $this->sAddress, mail goes to:".$oIfSubj->get_address());
    }//update
```

```php
<?php
class ClsMain 
{
    public static function main(Array $arArgs=[])
    {
        $arAddress = ["abc 123","cde 543","efg 987","rstu 0997"
            ,"kjf 8987","ere 456","opi 2454","werw 3636","erwc 879"
            ,"ety 741","lkj 369"];
        
        $iAttemps = 100;
        for($i=0;$i<$iAttemps;$i++)
        {
            $sAddressPo = array_rand($arAddress,1);
            $sAddressPo = $arAddress[$sAddressPo];
            $sAddressMb = array_rand($arAddress,1);
            $sAddressMb = $arAddress[$sAddressMb];
            
            \dg::p("po: $sAddressPo, mb: $sAddressMb","i=$i");

            $oMailBox1 = new ClsMailBox($sAddressMb);     
            $oPostOff = new ClsPostOffice($sAddressPo);

            //mailbox 1 comprueba si tiene email
            $oPostOff->add_observer($oMailBox1);
            //pregunta si hay email y si hay muestra por pantalla You have mail (oMailbox.update())
            $oPostOff->new_mail();
            //deja de observar
            $oPostOff->remove_observer($oMailBox1);
        }
        
        \dg::p("Main.main(): mails checked!!");
    }//main
    
}//ClsMain
```

- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b83d1d85831ec8cb01083e3/a9d57ad5b0ff7333fc2e2f15b2504da5/image.png" height="200" width="400">
