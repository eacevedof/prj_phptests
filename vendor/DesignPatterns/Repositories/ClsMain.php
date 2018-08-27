<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file ClsMain.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

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