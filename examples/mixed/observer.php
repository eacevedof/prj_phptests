<?php
include_once("vendor/autoload.php");

use DesignPatterns\Observer\MyObserver1;
use DesignPatterns\Observer\MyObserver2;
use DesignPatterns\Observer\MySubject;

$observer1 = new MyObserver1();
$observer2 = new MyObserver2();

$subject = new MySubject("test");

$subject->attach($observer1);
$subject->attach($observer2);
$subject->notify();

/* 
will output:

MyObserver1 - test
MyObserver2 - test
*/

$subject->detach($observer2);
$subject->notify();

/* 
will output:

MyObserver1 - test
*/
