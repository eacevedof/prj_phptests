<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Observer
 * @file MyObserver2.php
 * @version 1.0.0
 * @date 24-08-2018 20:19
 * @observations
 *  Patrones de diseño en laravel 
 *  Tutorial: [Análisis de los patrones de diseño con larave](https://youtu.be/SCpigk7UToM?t=1037)
 *  Ejemplo: [El interfaz SplSubject](http://php.net/manual/es/class.splsubject.php)
 *  Ejemplo Post Office: [Post Office](https://www.youtube.com/watch?v=rWvXJo3OAzs)
 */
namespace DesignPatterns\Observer;

use SplObserver;
use SplSubject;

class MyObserver2 implements SplObserver {
    public function update(SplSubject $subject) {
        echo __CLASS__ . ' - ' . $subject->getName();
    }
}