# [Youtube - Arquitectura Hexagonal con Adoración González](https://www.youtube.com/watch?v=mttFVrUBh3w)
- [speakerdeck.com - Diapositivas](https://speakerdeck.com/gtoboso/arquitectura-hexagonal-phpmad)
- [Twitter: @srtaDeveloper](https://twitter.com/srtaDeveloper)
- [Github - Este repo](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/SrtaDeveloper)
- [Behat - PHP Framework for testing](http://behat.org/en/latest/index.html)
- [Youtube - Arquitectura Hex y Laravel](https://www.youtube.com/playlist?list=PLHseQfu4Nn9fHNcLfF_ZP6noF24xtMtAf)

## Charla del 23 de septiembre de 2015. Grupo desarrolladores PHP - PHPMad
- [Diapositivas de la charla (speakerdeck)](https://speakerdeck.com/gtoboso/arquitectura-hexagonal-phpmad)

### Que ofrece la Arq Hex?
- Los cambios en un area de app deberian tener el menor número posible de efectos colaterales.
- Agregar nuevas funcionalidades o formas de interactuar con la app no deberia requerir grandes cambios de código.
- Los procesos de depuración y testeo deberian requerir el menor número de soluciones temporales como sea posible y ser relativamente fáciles.

### Que es?
- Patrón de arquitectura de software.
- Versión ampliada de la arq en 3 capas.

### [Puertos y adaptadores](https://youtu.be/mttFVrUBh3w?t=315)
- Identificamos puertos de E/S
- Usamos **adaptadores** para transformar inputs y outputs
- Organizamos y diseñamos clase para desacoplar (**interfaces**)

### [Esquema](https://youtu.be/mttFVrUBh3w?t=347)
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/622db0fe57d98923053cbee633501933/image.png" width="300" height="250"/>
-
```yalm
- Inputs
    - Http          adaptador1
    - Cli           adaptador2
    - Integracion   adaptador3
- hexagono
    - puertos de entrada
    - aplicación
    - dominio
    - puertos de salida
- Outputs
    - Notificación
        - adaptador5    Cola de mensajes
        - adaptador6    Email
    - Persistencia
        - adaptador7    Alguna BD
```
- [Clean Architecture - Esquema](https://youtu.be/mttFVrUBh3w?t=472)
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/a49fb63d3f59c785e2ce1fcb08fdb26f/image.png" width="300" height="250"/>
    - Tiene un concepto similar

### [Héxagono de Aplicación](https://youtu.be/mttFVrUBh3w?t=489)
- Lo que tiene
- Modelo de dominio
    - Clases, interfaces y servicios del dominio
- Servicios propios de la app
- Subscribers y listeners de eventos del dominio
    - @to-do Que son eventos de dominio?
- Eventos de la app
    - @to-do Que son los eventos de la app?
- Comandos
    - [Acciones a realizar a partir de la inyección de un objeto](https://www.arquitecturajava.com/command-pattern-tareas/)
    - Ejemplo: validarProducto,imprimirProducto,enviarPorCorreo

- Bus de comandos
    - Enrutador de comandos

### [Antes de descubir la arq hex](https://youtu.be/mttFVrUBh3w?t=528)
- Nuevo proyecto
- definir el `composer.json`
- requerir:
    - Symfony
    - Doctrine
    - [PHPUnit - (TDD metodologia de programación orientada al testing)](https://youtu.be/TGUcOe5rL7c?t=65)
- UserAccountBundle (primer paso)
    - [Que es un bundle?](https://symfony.com/doc/current/bundles.html#bundle-directory-structure)
        - Estructura de codificación sugerida por Symfony. A partir de la version 4 ha quedado obsoleta.
        - Solo se deben usar bundles para compartir código y funcionalidad entre multiple apps.

### [Casos de uso](https://youtu.be/mttFVrUBh3w?t=574)
- En arq hex la forma de atacar un problema es discernir los casos de uso
- Que tiene que ser capaz de hacer mi app?
- Definición de los casos pensando en el hexágono de la app
- Constituyen una API

#### Ejemplo
- Registrar una cuenta de usuario
- Habilitar una cuenta de usuario
- Deshabilitar una cuenta de usuario
- Modificar el perfil de una cuenta de usurario
- Borrar una cuenta de usuario
- [~ Resetear la contraseña ~](https://youtu.be/mttFVrUBh3w?t=643)
- Despues de tener definidos los casos de uso con Behat voy registrando los casos y los voy probando

### [App agnóstica del contexto](https://youtu.be/mttFVrUBh3w?t=856)
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/9316c354e33eda57fcd6181178a45df4/image.png" width="300" height="250"/>
- Como los datos van a llegar desde distintos origenes necesito un elemento que me gestione todas esas entradas
- Unifique y adapte a la app. Es un puerto de entrada. Es un **comando** [`class RegisterUserAccountCommand implements CommandInterface`](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Command/RegisterUserAccountCommand.php)
- El origen puede variar:
    - [**WebController**](https://youtu.be/mttFVrUBh3w?t=971)
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/8961d56242b2c5c086ef5535b6395048/image.png" width="300" height="250"/>
    - [**Symfony Console Command**](https://youtu.be/mttFVrUBh3w?t=991)
    - <img src="https://trello-attachments.s3.amazonaws.com/5b8bf24a217c8e0d0c69973e/600x441/02883d7737a85328c44a3c28be5d0952/image.png" width="300" height="250"/>

### El commandbus
- <img src="https://trello-attachments.s3.amazonaws.com/5b8bf24a217c8e0d0c69973e/600x424/4b98f2f9e3ba227218e7c9640dbbe111/image.png" width="200" height="150"/>  
- No es indispensable
- Se podria hacer lo mismo con comandos autoejecutables.  Que es?...
- Se usa commandbus para que los comandos sigan siendo simples mensajes, como **"data transfer object"** y que la responsabilidad de como se gestiona y lo que son sean responsabilidades distintas.
- Pq el decimos que el commandbus es una entrada a la app? Pq la implementación interna del bus lo que va a contener internamente es un mapa de correspondencia entre los comandos y el servicio de app que sabe gestionar el comando
- Los **servicio de aplicación** que saben manejar los comandos son los **Handler**
    - Se puede optar por n comandos => n handlers
    - o una única clase Handler que tenga n metodos y en algun sitio tener definido que metodo se encarga de gestionar que comando.

### Command Handler
- [DesignPatterns\App\Handler\RegisterUserAccountCommandHandler implements CommandHandlerInterface](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Handlers/RegisterUserAccountCommandHandler.php)
- [Patrón repositorio](http://fernandoescolar.github.io/2013/01/07/patrones-de-diseo-repository/)
    - La idea es que un objeto “Repository” actúe como una colección en memoria del modelo de dominio. A esta colección de objetos podremos añadirle o quitarle elementos y además realizar búsquedas filtradas
    - una capa dentro de nuestra aplicación cuya misión sea mover la información entre los objetos de c# y la base de datos. Además esta capa va a aislar el comportamiento de la base de datos, del de nuestros objetos, haciendo que nuestra aplicación no esté acoplada con nuestra fuente de almacenamiento 
- Todos los Command Handler deben implementar CommandHandlerInterface (solo metodo handle(RegisterUserAccountCommand $command))
- Toda la lógica de negocio deberia ir aqui y no en el controlador ni en ningún otro lado, asi las pruebas seran más fiables.

### [Dominio](https://youtu.be/mttFVrUBh3w?t=1260)
- Lo que no es conveniente hacer:
    - Parece logico que si se esta manejando cuentas de usuario se tenga una clase **UserAccount**
    - Sera tipo Entidad con unos atributos que la definen
    - La clase no debe ser la que sugiere Doctrine con sus anotaciones 
    - [Metodos de Lifecycle Events - Doctrine y Symfony](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#lifecycle-events)
        - son los eventos que ocurren en el proceso del **CRUD**
    - La clase de evento de dominio[ **UserAccountRegisteredEvent extends SymfonyEvent**](https://youtu.be/mttFVrUBh3w?t=1472) 
        - Se lanza cuando una cuenta de usuario es creada
        - No parece tan engorroso como las anotaciones de doctrine
        - Si es un evento es un mensaje que se lanza como consecuencia de que ha pasado algo en la app
        - Necesito realmente que para que se lance un evento sea un evento de Symfony?. No
        - Se esta vinculando un evento propio a una tecnología de terceros. (SymfonyEventDispatcher)
        - Esto contradice SOLID - Inversión de dependencia.
            - Las clases de alto nivel no deben depender de las de bajo nivel
            - Las abstracciones no deben depender de los detalles. Los detalles deben hacerlo de las abstracciones.
            - Ejemplos:
            - La **UserAccount** que es de **alto nivel** no hacerla depender de algo de **bajo nivel** como es la **persistencia de doctrine**
            - El evento del dominio que es de alto nivel no hacerlo depender de symfony que es de bajo nivel
    - Hay que desacoplar los componentes del dominio de tecnologias de terceros
    - <img src="https://trello-attachments.s3.amazonaws.com/5b8bf24a217c8e0d0c69973e/600x511/3dea3251020285db5124e106af4e9e45/image.png" width="200" height="150"/>     
- [Clase \App\Domain\UserAccount sin dependencias](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Domain/UserAccount.php)  
- Independientemente que la persistencia seria una bd utilizando el ORM de doctrine
- La clase [UserAccountRegisteredEvent](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Domain/Event/UserAccountRegisteredEvent.php)
- La clase [DoctrineORMUserAccount](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Infrastructure/Doctrine/ORM/DoctrineORMUserAccount.php)
- [Dos clases muy importantes:](https://youtu.be/mttFVrUBh3w?t=1814)
    - Single Responsability
    - [UserAccountFactoryInterface](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Domain/UserAccountFactoryInterface.php)
        - `public function createUserAccount($email,$password,$firstname,$lastname);`
    - [UserAccountRepositoryInterface](https://github.com/eacevedof/prj_phptests/blob/master/vendor/DesignPatterns/SrtaDeveloper/App/Domain/UserAccountRepositoryInterface.php)
        - `findById($id);`
        - `findByEmail($id);`
        - `add(UserAccount $userAccount);` 
- En el dominio lo único que debe haber son las interfaces del repositorio y la factoria con los metodos que tiene que implementar cualquier clase ubicada en la infraestructura que funcione como un repositorio o como factoría de cuentas de usuarios independientemente de la tecnología que haya debajo.
    - <img src="https://trello-attachments.s3.amazonaws.com/5b8bf24a217c8e0d0c69973e/600x447/89613d3560ff13bf108b68d8e0e39165/image.png" width="200" height="150"/>  
- Los repositorios son puertos de salida
- Las implementaciones concretas del repositorio van a ser los **adaptadores** de la persistencia en la bd que tengamos
- [Utilizando la Herencia e Interfaces para el desacoplado](https://youtu.be/mttFVrUBh3w?t=1980)
- [Interfaces](https://youtu.be/mttFVrUBh3w?t=2011)
    - Invierten el control "forzado" a la implementación concreta a cumplir lo definido en el modelo.
    - Hacemos que la tecnología se adapte a lo que define la app
    - Modelo y aplicación desacoplados de la tecnologia externa
    - Muy mantenible

### [La infraestructura](https://youtu.be/mttFVrUBh3w?t=2054)
- Es el sitio donde se pone la conf del mapeo de nuestra entidad a la bd
- Implementaciones de otros servicios del modelo de dominio y de la app como puede ser el **Commad Bus y/o Mailer**
- 

### Estructura de archivos:
- **comando win: tree /f**
```php
───App
│   ├───Command
│   │   │   RegisterUserAccountCommand.php
│   │   │
│   │   └───CommandInterface
│   │           CommandBusInterface.php
│   │
│   ├───Domain
│   │   │   UserAccount.php
│   │   │   UserAccountFactoryInterface.php
│   │   │   UserAccountRepositoryInterface.php
│   │   │
│   │   ├───Event
│   │   │       UserAccountRegisteredEvent.php
│   │   │
│   │   └───Service
│   │           MailerAdapterInterface.php
│   │           MailerFactory.php
│   │
│   ├───Handlers
│   │       RegisterUserAccountCommandHandler.php
│   │
│   └───Infrastructure
│       ├───CommandBus
│       │       CommandBus.php
│       │
│       ├───Doctrine
│       │   └───ORM
│       │           DoctrineORMUserAccount.php
│       │           DoctrineORMUserAccount.yaml
│       │           DoctrineORMUserAccountManager.php
│       │           InMemoryUserAccountManager.php
│       │
│       └───Mailer
│               SwiftMailerAdapter.php
│
```
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/ec91626ebebcbb3359e290312b025cec/image.png" width="200" height="400">
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/05c59c4c62955f65ffb6550ba6ca2d16/image.png" width="200" height="50">


```php
───App
│   ├───Command
│   │   │   RegisterUserAccountCommand.php  "modelo" que implementa CommandInterface
│   │   │
│   │   └───CommandInterface
│   │           CommandBusInterface.php     "interfaz" con metodo execute($command)
│   │
│   ├───Domain
│   │   │   UserAccount.php                     "modelo simple"
│   │   │   UserAccountFactoryInterface.php     "interfaz" con metodo createUserAccount(email,pass...)
│   │   │   UserAccountRepositoryInterface.php  "interfaz" metodos: findbyid,findbyemail,add($useraccount)
│   │   │
│   │   ├───Event
│   │   │       UserAccountRegisteredEvent.php  "clase simple"
│   │   │
│   │   └───Service
│   │           MailerAdapterInterface.php      "interfaz" metodo send(email,subject,body)
│   │           MailerFactory.php               "clase simple" metodo sendRegistrationEmail(email) usa adapter->send
│   │
│   ├───Handlers
│   │       RegisterUserAccountCommandHandler.php "clase" que implementa CommandHandlerInterface.handle($command)
│   │
│   └───Infrastructure
│       ├───CommandBus
│       │       CommandBus.php  "clase" que implementa CommandBusInterface.execute($command)
│       │
│       ├───Doctrine
│       │   └───ORM
│       │           DoctrineORMUserAccount.php  "clase" extiende "UserAccount"
│       │           DoctrineORMUserAccount.yaml configuración de campos
│       │           DoctrineORMUserAccountManager.php   "clase" implementa UserAccountRepositoryInterface, UserAccountFactoryInterface
│       │           InMemoryUserAccountManager.php  "clase" implementa UserAccountRepositoryInterface, UserAccountFactoryInterface
│       │
│       └───Mailer
│               SwiftMailerAdapter.php  "clase" implementa MailerAdapterInterface.send(email,subject,body)
│
```






