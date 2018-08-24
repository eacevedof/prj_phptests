<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Observer
 * @file MyObserver1.php
 * @version 1.0.0
 * @date 24-08-2018 20:19
 * @observations
 *  Patrones de diseño en laravel 
 *  Tutorial: https://youtu.be/SCpigk7UToM?t=1037
 */
namespace DesignPatterns\Observer;

use SplObserver;
use SplSubject;

class MyObserver1 implements SplObserver {
    public function update(SplSubject $subject) {
        echo __CLASS__ . ' - ' . $subject->getName();
    }
}