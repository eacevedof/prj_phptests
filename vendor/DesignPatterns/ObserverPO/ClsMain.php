<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file ClsMain.php
 * @version 1.0.1
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo [Post Office Main Class](https://youtu.be/rWvXJo3OAzs?t=285)
 */
namespace DesignPatterns\ObserverPO;

class ClsMain 
{
    public static function main(Array $arArgs=[])
    {
        $oMailBox1 = new ClsMailBox("");     
        $oPostOff = new ClsPostOffice("street xxx123");
        
        //mailbox 1 comprueba si tiene email
        $oPostOff->add_observer($oMailBox1);
        //pregunta si hay email y si hay muestra por pantalla You have mail (oMailbox.update())
        $oPostOff->new_mail();
        //deja de observar
        $oPostOff->remove_observer($oMailBox1);
    }//main
    
}//ClsMain