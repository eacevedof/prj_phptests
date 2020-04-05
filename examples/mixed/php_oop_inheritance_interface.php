<?php
/**
 * @file: php_oop_inheritance_interface.php
 * @info: pruebas de inyeccion de dependencias a partir de clase madre interfaces
 */

interface ICommon
{
    public function run();
}

interface IPrint extends ICommon
{
    public function printme();
}

interface ILog extends ICommon
{
    public function logme();
}

abstract class AbsMother implements IPrint, ILog
{
    protected $attr_mother;

    public function __construct($attr_mother="im AbsMother")
    {
        $this->attr_mother = $attr_mother;
    }

    public function printme(){ echo "<pre>$this->attr_mother</pre>";}
}

class Daughter extends AbsMother
{
    public function __construct($attr_mother = "im Daughter")
    {
        parent::__construct($attr_mother);
    }

    public function run()
    {
        echo "<pre>$this->attr_mother is running</pre>";
    }

    public function logme()
    {
        echo "<pre>$this->attr_mother is logging</pre>";
    }
}

class Granddaughter extends Daughter
{
    public function __construct($attr_mother = "im Granddaughter")
    {
        parent::__construct($attr_mother);
    }
}

class Notfamily implements IPrint
{

    public function run()
    {
        echo "<p>Running Not Family</p>";
    }

    public function printme()
    {
        echo "<p>Printing Not FamilY</p>";
    }
}

class Strager implements ILog
{

    public function run()
    {
        // TODO: Implement run() method.
    }

    public function logme()
    {
        // TODO: Implement logme() method.
    }
}

class Main
{
    public function __construct(IPrint $IPrint)
    {
        $IPrint->run(); //esta es de ICommon
        $IPrint->printme();
        //$IPrint->logme();
    }
}

(new Main(new Granddaughter())); //ok
(new Main(new Notfamily())); //ok
(new Main(new Strager()));//nok no tiene printme