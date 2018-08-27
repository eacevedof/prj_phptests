# [Youtube - Análisis de los Patrones de diseño con Laravel #laravelIO](https://youtu.be/SCpigk7UToM?t=1688)
## Patron Repositories

- Permite separar los datos de la lógica de negocio
- Un repositorio no es más que un conjunto de operaciones que se realizarán utilizando el modelo asociado
- Todo el CRUD se pasaria al repositorio
- El controlador recibiria como inyección de dependencia en su constructor a la interface de repositorio
- De este modo se puede tener distintas interfaces 
- [Explicación de flexibilidad al usar interfaces y distintas fuentes de datos](https://youtu.be/SCpigk7UToM?t=2329)
- [IoC Container](https://laravel.com/docs/4.2/ioc)
    - Comprueba que Interfaz se esta usando y en base a esta busca la clase final que está relacionada y la instancia automaticamente
    - Esto permite que si usamos las interfaces en los constructores posteriormente se pueda cambiar la fuente de datos
por ejemplo, **MongoUserRepository**. 
    - Donde y como se usaria un **ServiceProvider**
    - Un **ServiceProvider** mapea Interfaz -> Clase Final

```php
<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file UserRepository.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

use DesignPatterns\Repositories\IfUserRepository;
use DesignPatterns\Repositories\UserModel;

class UserRepository implements IfUserRepository
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

}//UserRepository
```