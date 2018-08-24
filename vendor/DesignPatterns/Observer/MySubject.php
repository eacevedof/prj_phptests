<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Observer
 * @file MySubject.php
 * @version 1.0.0
 * @date 24-08-2018 20:19
 * @observations
 *  Patrones de diseño en laravel 
 *  Tutorial: https://youtu.be/SCpigk7UToM?t=1037
 */
namespace DesignPatterns\Observer;

use SplObjectStorage;
use SplObserver;
use SplSubject;

class MySubject implements SplSubject {
    private $_observers;
    private $_name;

    public function __construct($name) {
        $this->_observers = new SplObjectStorage();
        $this->_name = $name;
    }

    public function attach(SplObserver $observer) {
        $this->_observers->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->_observers->detach($observer);
    }

    public function notify() {
        foreach ($this->_observers as $observer) {
            $observer->update($this);
        }
    }

    public function getName() {
        return $this->_name;
    }
}//MySubject