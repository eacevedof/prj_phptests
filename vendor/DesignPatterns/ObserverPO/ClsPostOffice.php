<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file ClsPostOffice.php
 * @version 1.0.0
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo [PostOffice.java](https://youtu.be/rWvXJo3OAzs?t=227)
 */
namespace DesignPatterns\ObserverPO;

use DesignPatterns\ObserverPO\IfSubject;
use DesignPatterns\ObserverPO\IfObserver;

class ClsPostOffice implements IfSubject
{
    private $sAddress;
    private $arObservers;
    
    public function __construct(String $sAddress) {
        $this->sAddress = $sAddress;
        $this->arObservers = [];
    }//__construct
    
    public function new_mail()
    {
        //foreach observers as obs.update()
        $this->notify_observers();
    }//new_mail
    
    //@override
    public function add_observer(IfObserver $oIfObs)
    {
        $this->arObservers[] = $oIfObs;
    }//add_observer

    //@override
    public function remove_observer(IfObserver $oIfObs) 
    {
        if(($iPos = array_search($oIfObs,$this->arObservers))!== false)
            unset($this->arObservers[$iPos]);    
    }//remove_observer
        
    //@override
    public function notify_observers() 
    {
        foreach($this->arObservers as $oObs)
            if(method_exists($oObs,"update"))
                $oObs->update();
    }//notify_observers

    function get_address(){return $this->sAddress;}

    function set_address($sAddress){$this->sAddress = $sAddress;}

}//ClsPostOffice