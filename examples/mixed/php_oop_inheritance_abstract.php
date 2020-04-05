<?php
/**
 * @file: php_oop_inheritance_abstract.php
 * @info: pruebas de inyeccion de dependencias a partir de clase madre abstracta
 */

abstract class AbsMother
{
    protected $attr_mother;

    public function __construct($attr_mother="im AbsMother")
    {
        $this->attr_mother = $attr_mother;
    }

    public function printme()
    {
        echo "<pre>$this->attr_mother</pre>";
    }
}

class Daughter extends AbsMother
{
    public function __construct($attr_mother = "im Daughter")
    {
        parent::__construct($attr_mother);
    }
}

class Granddaughter extends Daughter
{
    public function __construct($attr_mother = "im Granddaughter")
    {
        parent::__construct($attr_mother);
    }
}

class Main
{
    public function __construct(AbsMother $objmother)
    {
        $objmother->printme();
    }
}

//prohibido. No se puede crear una clase
//(new Main(new AbsMother()));

(new Main(new Daughter()));      //ok
(new Main(new Granddaughter())); //ok
