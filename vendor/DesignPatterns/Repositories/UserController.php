<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file UserController.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

use DesignPatterns\Repositories\IfUserRepository;

class UserController 
{
    private $oIfUserRepo;
    
    //IfUserRepository, agrupa: MongoUserRepo y UserRepo
    public function __construct(IfUserRepository $oIfUserRepo) 
    {
        $this->oIfUserRepo = $oIfUserRepo;
    }//__construct

    public function post_guardar_usuario()
    {
        $arUsuario = Input::all();
        $oUsuario = $this->oIfUserRepo->crear($arUsuario);
        return $oUsuario;
    }//post_guardar_usuario

    public function post_buscar_usuario($id)
    {
        $oUsuario = $this->oIfUserRepo->buscar_por_id($id);
        return $oUsuario;
    }//post_buscar_usuario
}//UserController