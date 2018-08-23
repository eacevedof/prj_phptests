<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Ifsp\Delorean
 * @file Delorean.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\Ifsp;

use Solid\Ifsp\IfCar;
use Solid\Ifsp\IfTimeMachine;

class Delorean implements IfCar,IfTimeMachine
{
    public function start_engine()
    {
        //start engine
    }
    
    public function accelerate()
    {
        //accelerate
    }
    
    public function back_to_past() {
        ;
    }
    
    public function back_to_the_future() {
        ;
    }
}//Delorean