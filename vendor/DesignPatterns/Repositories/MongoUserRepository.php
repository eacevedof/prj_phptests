<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file MongoUserRepository.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

use DesignPatterns\Repositories\IfUserRepository;
use DesignPatterns\Repositories\UserModel;

class MongoUserRepository implements IfUserRepository
{
    private $oModel;
    
    public function __construct(UserModel $oUser) 
    {
        $this->oModel = $oUser;
    }

    public function todos() 
    {
        return $this->oModel->all();
    }
    
    public function crear(array $arDatos) {
        $this->oModel->create($arDatos);
        return $this->oModel;
    }

    public function buscar_por_id(String $id)
    {
        return $this->oModel->find($id);
    }    
    
    public function buscar_por_email(String $sEmail) 
    {
        return $this->oModel->where("email","=",$sEmail)->get();
    }
    
    public function borrar(String $id) 
    {
        $oUser = $this->buscar_por_id($id);
        return $oUser->delete();
    }
    
    public function actualizar(array $arDatos, String $id) 
    {
        $oUsuario = $this->buscar_por_id($id);
        $oUsuario->fill($arDatos);
        $oUsuario->save();
        return $oUsuario;
    }

}//MongoUserRepository