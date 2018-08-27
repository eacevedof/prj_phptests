<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file UserModel.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

class UserModel 
{
   
    public function __construct() 
    {
        ;
    }
    
    public function find($id)
    {
        return $this;
    }
    
    public function get(){return $this;}
    
    public function where($field,$operator,$value)
    {
        return $this;
    }
    
    public function all(){ return [];}
    
    public function create($arDatos)
    {
        \dg::pl($arDatos,"created");
        return $this;
    }
    
    public function delete()
    {
        \dg::p("user deleted");
        return $this;
    }
    
    public function fill($arDatos)
    {
        return $this;
    }
    
    public function save()
    {
        return $this;
    }
    

}//UserModel